import mysql.connector
import pandas as pd

def collection_data_from_database(): 

  connection = mysql.connector.connect(
    host = "127.0.0.1", 
    user = "root", 
    password = "",
    database="course_and_university_recommendation_system"
  )

  cursor = connection.cursor()

  query = """
    SELECT 
      cd.id,
      cd.course_honour_name, 
      cd.tuition_fees, 
      cd.credit_hours, 
      cd.duration, 
      cd.minimum_grade, 
      cd.specific_subjects, 
      cd.merit_mark, 
      cd.english_requirement_skill, 
      cd.ranking_qs_no_start_by_subject, 
      cd.ranking_qs_no_end_by_subject, 
      cd.ranking_qs_year_by_subject, 
      cd.ranking_the_no_start_by_subject, 
      cd.ranking_the_no_end_by_subject,
      cd.ranking_the_year_by_subject, 
      cd.course_qualification, 
      cd.course_website,
      u.uni_name, 
      u.uni_address, 
      u.campus, 
      u.website, 
      u.uni_type, 
      u.contact_no, 
      u.email,
      u.ranking_qs_no_start, 
      u.ranking_qs_no_end, 
      u.ranking_qs_year, 
      u.ranking_the_no_start,
      u.ranking_the_no_end,
      u.ranking_the_year, 
      s.state_name, 
      a.area_name, 
      a.postcode, 
      c.course_category, 
      c.course_aspect
    FROM coursedetails cd
    JOIN universities u ON cd.university_id = u.id
    JOIN courses c ON cd.course_id = c.id
    JOIN areas a ON u.area_id = a.id
    JOIN states s ON u.state_id = s.id;
  """

  cursor.execute(query)

  headers = [i[0] for i in cursor.description]

  rows = cursor.fetchall()

  dataset = pd.DataFrame(rows, columns=headers)

  cursor.close()
  connection.close()

  return dataset