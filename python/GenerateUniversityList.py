import numpy as np
import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.pipeline import Pipeline
from sklearn.compose import ColumnTransformer
from sklearn.preprocessing import OneHotEncoder
import matplotlib.pyplot as plt
from flask import Flask, request, jsonify
from flask_cors import CORS

import mysql.connector

import findTheDistance as ftd

# 1. insert the dataset and input data
# dataset have to import data from the database

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
    uni_name
  FROM universities
  """

  cursor.execute(query)

  rows = cursor.fetchall()

  print(rows)

  cursor.close()
  connection.close()

  return  rows

def compare_result_and_requirement(dataset):

  # Features and labels 
  X = dataset[['', '', '']]
  y = dataset['course_honour_name']

  categorical = []
  numerical = []

  preprocessor = ColumnTransformer(
      transformers=[
          ('cat', OneHotEncoder(), categorical)
      ],
      remainder='passthrough'  # keep numeric columns
  )

  model =DecisionTreeClassifier()

  model.fit(X, y)

  student_input = []
  recommended = model.predict([encoded_input])

  return model


# @app.route('/final_submit', method=['POST'])
# def collection_of_data():
    
#     # input data have to import the data from the html side 
#     app = Flask(__name__)
#     CORS(app) # Allow requests from Laravel frontend

#     data = request.get_json()

#     if not data: 
#       return jsonify({'message': 'No data received'}), 400

#     # name = data.get('name')

#     print(data)

#     return data


# 2. generate the university list using decision tree algorithm
if __name__ == '__main__':



  # input_data_html = collection_of_data()
  input_data_db = collection_data_from_database()
  # Compared_uni_and_course = compare_result_and_requirement(input_data_db)


  # 2.1 Identify the university type (public or private) and the preferences



  # 2.2 compare the result and requirement 



  # 2.3 store the result into the recommended university list (continued until all the universites are compared)





  # 2.4 rearrange the list based on the preferences 



  # 2.4.1 Location (State)



  # 2.4.2 Shortest Distance



  # 2.4.3 Area of Interest 



  # 2.4.4 Expected Total Tuition Fees 



  # 2.5 sorting 

