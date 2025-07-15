import numpy as np
import pandas as pd
from sklearn.tree import DecisionTreeClassifier
from sklearn.pipeline import Pipeline
from sklearn.compose import ColumnTransformer
from sklearn.preprocessing import OneHotEncoder
import matplotlib.pyplot as plt
from flask import Flask, request, jsonify
from flask_cors import CORS

from sqlalchemy import create_engine

import findTheDistance as ftd

# 1. insert the dataset and input data
# dataset have to import data from the database

db_user = 'root'
db_password = ''  
db_host = '127.0.0.1'
db_port = '3306'
db_name = 'course_and_university_recommendation_system'

# SQLAlchemy connection string
connection_str = f"mysql+pymysql://{db_user}:{db_password}@{db_host}:{db_port}/{db_name}"
engine = create_engine(connection_str)

query = """
SELECT
  cd.id AS coursedetail_id,
  c.course_aspect,
  cd.minimum_grade,
  cd.tuition_fees,
  cd.duration,
  u.uni_type,
  u.state_id,
  CONCAT(cd.course_honour_name, ' - ', u.uni_name) AS recommendation
FROM
  coursedetails cd
JOIN
  universities u ON cd.university_id = u.id
JOIN
  courses c ON cd.course_id = c.id
"""

dataset = pd.read_sql(query, engine)

print(dataset.head())

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

# input data have to import the data from the html side 
app = Flask(__name__)
CORS(app) # Allow requests from Laravel frontend

@app.route('/student-information', method=['POST'])
def student_information():
    data = request.get_json()
    return jsonify({"message": "Received successfully"})

@app.route('', method=[''])
def 

# 2. generate the university list using decision tree algorithm

model.fit(X, y)

student_input = []
recommended = model.predict([encoded_input])

# 2.1 Identify the university type (public or private) and the preferences



# 2.2 compare the result and requirement 



# 2.3 store the result into the recommended university list (continued until all the universites are compared)





# 2.4 rearrange the list based on the preferences 



# 2.4.1 Location (State)



# 2.4.2 Shortest Distance



# 2.4.3 Area of Interest 



# 2.4.4 Expected Total Tuition Fees 



# 2.5 sorting 
