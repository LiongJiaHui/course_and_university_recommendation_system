import unittest
from unittest.mock import patch
import pandas as pd

class TestComparisonFeatureTest(unittest.TestCase): 
    
    def setUp(self):
        # Dataset with multiple courses
        self.dataset = pd.DataFrame([
            {
                'id': 1,
                'specific_subjects': "Math, Physics",
                'minimum_grade': 2.75,
                'merit_mark': 70,
                'english_requirement_skill': 3,
                'course_honour_name': "BSc Physics",
                'tuition_fees': 10000,
                'credit_hours': 120,
                'duration': "3 years",
                'course_qualification': "Bachelor",
                'course_website': "http://physics.uni",
                'ranking_qs_no_start_by_subject': 100,
                'ranking_qs_no_end_by_subject': 200,
                'ranking_qs_year_by_subject': 2024,
                'ranking_the_no_start_by_subject': 150,
                'ranking_the_no_end_by_subject': 250,
                'ranking_the_year_by_subject': 2024,
                'uni_name': "Uni A",
                'uni_address': "City A",
                'campus': "Main",
                'website': "http://unia.edu",
                'uni_type': "Public",
                'contact_no': "12345",
                'email': "info@unia.edu",
                'ranking_qs_no_start': 50,
                'ranking_qs_no_end': 100,
                'ranking_qs_year': 2024,
                'ranking_the_no_start': 70,
                'ranking_the_no_end': 120,
                'ranking_the_year': 2024,
                'state_name': "StateX",
                'area_name': "AreaY",
                'postcode': "12345",
                'course_category': "Science",
                'course_aspect': "STEM"
            },
            {
                'id': 2,
                'specific_subjects': "Biology, Chemistry",
                'minimum_grade': 3.75,
                'merit_mark': 80,
                'english_requirement_skill': 4,
                'course_honour_name': "BSc Biology",
                'tuition_fees': 12000,
                'credit_hours': 125,
                'duration': "3 years",
                'course_qualification': "Bachelor",
                'course_website': "http://bio.uni",
                'ranking_qs_no_start_by_subject': 150,
                'ranking_qs_no_end_by_subject': 250,
                'ranking_qs_year_by_subject': 2024,
                'ranking_the_no_start_by_subject': 200,
                'ranking_the_no_end_by_subject': 300,
                'ranking_the_year_by_subject': 2024,
                'uni_name': "Uni B",
                'uni_address': "City B",
                'campus': "Main",
                'website': "http://unib.edu",
                'uni_type': "Private",
                'contact_no': "67890",
                'email': "info@unib.edu",
                'ranking_qs_no_start': 60,
                'ranking_qs_no_end': 110,
                'ranking_qs_year': 2024,
                'ranking_the_no_start': 80,
                'ranking_the_no_end': 130,
                'ranking_the_year': 2024,
                'state_name': "StateZ",
                'area_name': "AreaW",
                'postcode': "67890",
                'course_category': "Science",
                'course_aspect': "Biology"
            }
        ])

    def test_flow_student_qualifies_for_one_course(self):
        from Comparison import compare_result_and_requirement_v1
        subjects = [{"name": "Math", "marks": 3.00}, {"name": "Physics", "marks": 3.86}]
        result = compare_result_and_requirement_v1(self.dataset, subjects, merit_mark=80, MUETmarks=4)
        self.assertGreaterEqual(len(result), 1)  # at least one course
        self.assertIn("BSc Physics", result['course_honour_name'].values)

    def test_flow_student_qualifies_for_none(self):
        from Comparison import compare_result_and_requirement_v2
        subjects = [{"name": "History", "marks": 2.00}]
        result = compare_result_and_requirement_v2(self.dataset, subjects, MUETmarks=5)
        self.assertFalse(result.empty)

if __name__ == "__main__":
    unittest.main()