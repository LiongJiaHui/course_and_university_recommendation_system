import Comparison as comparison
import Sorting as sort
import CollectionDataFromDatabase as inputDatabase
import pandas as pd
from datetime import datetime 
import os

def generate_university_list(input_data_html):
  
  # 1. insert the dataset and input data

  # import data from the database
  input_data_db = inputDatabase.collection_data_from_database()

  print("The data from the database are exported")
  
  # 2. generate the university list using decision tree algorithm

  # 2.1 Identify the university type (public or private) and the preferences
  uni_type = input_data_html.get("unitype")
  subjects = input_data_html.get("subjects", [])
  MUETmarks= float(input_data_html.get("MUETmarks", 0))

  compared_result = pd.DataFrame()

  print("Starting the generate recommendation list")
  start_uni_type = datetime.now()

  if uni_type == "public":
    
    total_marks = 0.0
    number_of_subjects = len(subjects)

    for subject in subjects: 
      try: 
        mark = float(subject.get('marks'))
        total_marks += mark
      except: 
        print(f"Invalid mark value: {subject.get('marks')}")

    pngk = ((total_marks / 4.00) / number_of_subjects) * 90
    cocuriculum = float(input_data_html.get("cocuriculummarks", 0.0)) * 0.1
    merit_mark = pngk + cocuriculum

    filtered_universities = input_data_db[input_data_db['uni_type'] == "Public"]

    # compare the result and requirement and store the result into the recommended university list

    compared_result=comparison.compare_result_and_requirement_v1(filtered_universities, subjects, merit_mark, MUETmarks)

    # print(compared_result)
    
  elif uni_type == "private": 

    filtered_universities = input_data_db[input_data_db['uni_type'] == "Private"]

    print(filtered_universities)

    # compare the result and requirement and store the result into the recommended university list
    compared_result=comparison.compare_result_and_requirement_v2(filtered_universities, subjects, MUETmarks)

  end_uni_type = datetime.now()
  elapsed_uni_type = end_uni_type - start_uni_type
  print("Time taken for generating the recommendation list: ", elapsed_uni_type)

  # 2.4 rearrange the list based on the preferences 

  print("Goes to the preferences")
  start_preferences = datetime.now()

  preferences = input_data_html.get("preference")
  print(preferences)

  Recommendation_list = sort.sort_recommended_list(input_data_html, compared_result, preferences)

  end_preferences = datetime.now()
  elapsed_preferences = end_preferences - start_preferences
  print("Time taken for sorting: ", elapsed_preferences)

  print("Done the preferences sections")

  Recommendation_list = Recommendation_list[:9]

  return Recommendation_list


if "__name__" == "__main__":
  generate_university_list