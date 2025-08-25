import numpy as np
import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.tree import plot_tree
from sklearn.tree import _tree
from sklearn.pipeline import Pipeline
from sklearn.compose import ColumnTransformer
from sklearn.preprocessing import OneHotEncoder
import matplotlib.pyplot as plt
from decimal import Decimal 

import itertools

def compare_result_and_requirement_v1(dataset, subjects, merit_mark, MUETmarks):
    # --------------------------------
    # 1. Gather all possible subjects
    # --------------------------------
    all_subjects = set()
    for subs in dataset['specific_subjects']:
        for s in subs.replace("&", ",").replace("*", ",").split(","):
            s = s.strip()
            if s:
                all_subjects.add(s)

    # print(f"All subjects found in dataset: {all_subjects}")

    # Also add student subjects (in case not in dataset)
    student_subjects = [sub['name'] for sub in subjects]
    for s in student_subjects:
        all_subjects.add(s)

    all_subjects = sorted(all_subjects)

    # print(all_subjects)

    print("Comparison part: All the subjects are collected")

    # --------------------------------
    # 2. Encode dataset as presence matrix
    # --------------------------------
    course_rows = []
    for _, row in dataset.iterrows():
        course_subjects = row['specific_subjects'].replace("&", ",").replace("*", ",").split(",")
        course_subjects = [s.strip() for s in course_subjects if s.strip()]

        row_data = {}
        for sub in all_subjects:
            if len(course_subjects) == 0:
            # If no specific subjects are listed, require ALL subjects
                for sub in all_subjects:
                    row_data[sub] = float(row['minimum_grade'])
            else:
                if sub in course_subjects:
                    # required subject → store required minimum grade
                    row_data[sub] = row['minimum_grade']
                else:
                    row_data[sub] = 0.0  # not required

        row_data.update({
            'id': row['id'],           
            'merit_mark': row['merit_mark'],
            'english_requirement_skill': row['english_requirement_skill'],
        })
        course_rows.append(row_data)

    new_dataset = pd.DataFrame(course_rows)

    # --------------------------------
    # 3. Encode student input the same way
    # --------------------------------
    # Convert subjects into dictionary for quick lookup
    student_subject_dict = {s["name"]: float(s["marks"]) for s in subjects}

    student_row = {sub: student_subject_dict.get(sub, 0.0) for sub in all_subjects}
    student_row.update({
        'merit_mark': merit_mark,
        'english_requirement_skill': MUETmarks,
    })
    student_input = pd.DataFrame([student_row])

    # print(student_row)
    # print(student_input)
    # for sub in all_subjects: 
    #     print(student_input[sub])
    print("Comparison part: The student input are encoded")

    # --------------------------------
    # 4. Train model
    # --------------------------------
    X = new_dataset.drop(columns=['id'])
    y = new_dataset['id']

    model = DecisionTreeClassifier()
    model.fit(X, y)

    # --------------------------------
    # 5. Eligibility filter
    # --------------------------------

    eligible_courses = []
    for _, row in new_dataset.iterrows():
        course_id = row['id']
        meritMark = row['merit_mark']
        muet_req = row['english_requirement_skill']
        subject_ok = True

        # MUET check
        if MUETmarks < muet_req:
            subject_ok = False

        # Merit marks check
        if merit_mark < meritMark: 
            subject_ok = False

        # Subject-by-subject check
        for sub in all_subjects:
            required_mark = row[sub]
            student_mark = student_row.get(sub, 0.0)

            if required_mark > 0.0 and student_mark > 0.0:  # required subject and student mark are required marks
                if student_mark < required_mark:  # student fails this subject
                    if student_mark == 0.0: 
                        continue
                    else :
                        subject_ok = False

        if subject_ok:
            eligible_courses.append(course_id)

    eligible_courses = set(eligible_courses)

    # print(eligible_courses)
    print("Comparison part: Completed for the eligibility filter")

    # --------------------------------
    # 6. Predict probabilities
    # --------------------------------
    prediction = model.predict_proba(student_input)[0]
    course_probs = [(model.classes_[i], prediction[i]) for i in range(len(model.classes_))]

    eligible_predicted = [(course, prob) for course, prob in course_probs if course in eligible_courses]
    eligible_predicted.sort(key=lambda x: x[1], reverse=True)
    # eligible_predicted = eligible_predicted[:9]

    print("Comparison part: Done the predicted part")

    # --------------------------------
    # 7. Plot decision tree
    # --------------------------------
    # plt.figure(figsize=(14, 10))
    # plot_tree(
    #     model,
    #     filled=True,
    #     feature_names=X.columns,
    #     class_names=[str(c) for c in model.classes_]
    # )
    # plt.show()

    first_recommended_list= []

    for row in eligible_predicted:
      row = list(row)
      predicted_course_id = row[0]
      for index, data in dataset.iterrows():
        if predicted_course_id == data['id']:
          line = []
          line.append(data['id'])
          line.append(data['course_honour_name'])
          line.append(data['tuition_fees'])
          line.append(data['credit_hours'])
          line.append(data['duration'])
          line.append(data['course_qualification'])
          line.append(data['course_website'])
          line.append(data['ranking_qs_no_start_by_subject'])
          line.append(data['ranking_qs_no_end_by_subject'])
          line.append(data['ranking_qs_year_by_subject'])
          line.append(data['ranking_the_no_start_by_subject'])
          line.append(data['ranking_the_no_end_by_subject'])
          line.append(data['ranking_the_year_by_subject'])
          line.append(data['uni_name'])
          line.append(data['uni_address'])
          line.append(data['campus'])
          line.append(data['website'])
          line.append(data['uni_type'])
          line.append(data['contact_no'])
          line.append(data['email'])
          line.append(data['ranking_qs_no_start'])
          line.append(data['ranking_qs_no_end'])
          line.append(data['ranking_qs_year'])
          line.append(data['ranking_the_no_start'])
          line.append(data['ranking_the_no_end'])
          line.append(data['ranking_the_year'])
          line.append(data['state_name'])
          line.append(data['area_name'])
          line.append(data['postcode'])
          line.append(data['course_category'])
          line.append(data['course_aspect'])
      first_recommended_list.append(line)

    predicted_list = pd.DataFrame(first_recommended_list, columns=[
        'id', 'course_honour_name', 'tuition_fees', 'credit_hours', 'duration',
        'course_qualification', 'course_website', 'ranking_qs_no_start_by_subject',
        'ranking_qs_no_end_by_subject', 'ranking_qs_year_by_subject',
        'ranking_the_no_start_by_subject', 'ranking_the_no_end_by_subject',
        'ranking_the_year_by_subject', 'uni_name', 'uni_address', 'campus',
        'website', 'uni_type', 'contact_no', 'email', 
        'ranking_qs_no_start', 'ranking_qs_no_end', 'ranking_qs_year',
        'ranking_the_no_start', 'ranking_the_no_end', 'ranking_the_year',
        'state_name', 'area_name', 'postcode', 
        'course_category', 'course_aspect'
    ])

    # print(predicted_list)

    return predicted_list


def compare_result_and_requirement_v2(dataset, subjects, MUETmarks):

    # --------------------------------
    # 1. Gather all possible subjects
    # --------------------------------
    all_subjects = set()
    for subs in dataset['specific_subjects']:
        for s in subs.replace("&", ",").replace("*", ",").split(","):
            s = s.strip()
            if s:
                all_subjects.add(s)

    # student subjects with marks
    student_subjects = {sub['name']: float(sub['marks']) for sub in subjects}
    for s in student_subjects.keys():
        all_subjects.add(s)

    all_subjects = sorted(all_subjects)

    # print(all_subjects)
    print("Comparison part: All the subjects are gathered.")

    # --------------------------------
    # 2. Encode dataset as subject + grades + MUET
    # --------------------------------
    course_rows = []
    for _, row in dataset.iterrows():
        course_subjects = row['specific_subjects'].replace("&", ",").replace("*", ",").split(",")
        course_subjects = [s.strip() for s in course_subjects if s.strip()]

        row_data = {}
        for sub in all_subjects:
            if len(course_subjects) == 0:
            # If no specific subjects are listed, require ALL subjects
                row_data = {sub: float(row['minimum_grade']) for sub in all_subjects}
            else:
                row_data = {sub: (float(row['minimum_grade']) if sub in course_subjects else 0.0) for sub in all_subjects}

        row_data.update({
            'muet_required': row['english_requirement_skill'],
            'id': row['id']  # target is course ID
        })

        course_rows.append(row_data)

    new_dataset = pd.DataFrame(course_rows)

    # print(new_dataset)
    print("Comparison part: all the data from the database are encoded.")

    # --------------------------------
    # 3. Encode student input
    # --------------------------------
    student_row = {}

    student_row = {sub: student_subjects.get(sub, 0.0) for sub in all_subjects}
    student_row.update({
        'muet_required': MUETmarks
    })

    student_input = pd.DataFrame([student_row])

    # print(student_input)
    print("Comparison part: The student input are encoded.")

    # --------------------------------
    # 4. Train model (X=subjects+MUET, y=course id)
    # --------------------------------
    X = new_dataset.drop(columns=['id'])
    y = new_dataset['id']

    model = DecisionTreeClassifier()
    model.fit(X, y)

    print("Comparison part: Training model")

    # --------------------------------
    # 5. Predict course probabilities
    # --------------------------------
    prediction = model.predict_proba(student_input)[0]
    course_probs = [(model.classes_[i], prediction[i]) for i in range(len(model.classes_))]

    print("Comparisan part: Completed the prediction of the course probabilities")

    # --------------------------------
    # 6. Eligibility filter (check requirements)
    # --------------------------------
    eligible_courses = []
    for _, row in new_dataset.iterrows():
        course_id = row['id']
        muet_req = row['muet_required']

        # MUET check
        if MUETmarks < muet_req:
            subject_ok = False

        # Subject-by-subject check
        subject_ok = True
        for sub in all_subjects:
            required_mark = row[sub]
            student_mark = student_row.get(sub, 0.0)

            if required_mark > 0.0 and student_mark > 0.0:  # subject is required
                if student_mark < required_mark:  # student fails this subject
                    if student_mark == 0.0: 
                        continue
                    else :
                        subject_ok = False

        if subject_ok:
            eligible_courses.append(course_id)

    eligible_courses = set(eligible_courses)

    eligible_predicted = [(course, prob) for course, prob in course_probs if course in eligible_courses]
    eligible_predicted.sort(key=lambda x: x[1], reverse=True)
    # eligible_predicted = eligible_predicted[:9]

    # print(eligible_predicted)
    print("Comparison part: Completed the Eligibility filter (Check the subject required from the course requirement)")

    # --------------------------------
    # 7. Build recommendation list
    # --------------------------------
    dataset_dict = {row['id']: row for _, row in dataset.iterrows()}
    first_recommended_list = []

    for course_id, _ in eligible_predicted:
        data = dataset_dict[course_id]
        line = [
            data['id'], data['course_honour_name'], data['tuition_fees'],
            data['credit_hours'], data['duration'], data['course_qualification'],
            data['course_website'], data['ranking_qs_no_start_by_subject'],
            data['ranking_qs_no_end_by_subject'], data['ranking_qs_year_by_subject'],
            data['ranking_the_no_start_by_subject'], data['ranking_the_no_end_by_subject'],
            data['ranking_the_year_by_subject'], data['uni_name'], data['uni_address'],
            data['campus'], data['website'], data['uni_type'], data['contact_no'],
            data['email'], data['ranking_qs_no_start'], data['ranking_qs_no_end'],
            data['ranking_qs_year'], data['ranking_the_no_start'], data['ranking_the_no_end'],
            data['ranking_the_year'], data['state_name'], data['area_name'],
            data['postcode'], data['course_category'], data['course_aspect']
        ]
        first_recommended_list.append(line)

    predicted_list = pd.DataFrame(first_recommended_list, columns=[
        'id', 'course_honour_name', 'tuition_fees', 'credit_hours', 'duration',
        'course_qualification', 'course_website', 'ranking_qs_no_start_by_subject',
        'ranking_qs_no_end_by_subject', 'ranking_qs_year_by_subject',
        'ranking_the_no_start_by_subject', 'ranking_the_no_end_by_subject',
        'ranking_the_year_by_subject', 'uni_name', 'uni_address', 'campus',
        'website', 'uni_type', 'contact_no', 'email',
        'ranking_qs_no_start', 'ranking_qs_no_end', 'ranking_qs_year',
        'ranking_the_no_start', 'ranking_the_no_end', 'ranking_the_year',
        'state_name', 'area_name', 'postcode',
        'course_category', 'course_aspect'
    ])

    # print(predicted_list)
    print("Comparison part: Done for the recommendation part")

    return predicted_list