import unittest
from unittest.mock import patch
import pandas as pd

class TestComparisonUnitTest(unittest.TestCase):
    def setUp(self):
        # Mock dataset similar to DB structure
        self.dataset = pd.DataFrame([
            {
                'id': 1,
                'specific_subjects': "Math, Physics",
                'minimum_grade': 3.00,
                'merit_mark': 75,
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
            }
        ])

        self.subjects = [
            {"name": "Math", "marks": 3.75},
            {"name": "Physics", "marks": 3.50}
        ]

    def test_subject_extraction(self):
        from Comparison import compare_result_and_requirement_v1
        result = compare_result_and_requirement_v1(self.dataset, self.subjects, merit_mark=80, MUETmarks=4)
        self.assertFalse(result.empty)
        self.assertIn("BSc Physics", result['course_honour_name'].values)

    def test_ineligible_due_to_muet(self):
        from Comparison import compare_result_and_requirement_v2
        result = compare_result_and_requirement_v2(self.dataset, self.subjects, MUETmarks=2)  # too low
        self.assertTrue(result.empty)  # should filter out

    def test_ineligible_due_to_merit(self):
        from Comparison import compare_result_and_requirement_v1
        result = compare_result_and_requirement_v1(self.dataset, self.subjects, merit_mark=70, MUETmarks=4)
        self.assertTrue(result.empty)  # merit not enough

    def test_course_selected_when_criteria_met(self):
        from Comparison import compare_result_and_requirement_v2
        result = compare_result_and_requirement_v2(self.dataset, self.subjects, MUETmarks=4)
        self.assertEqual(len(result), 1)
        self.assertEqual(result.iloc[0]['course_honour_name'], "BSc Physics")

if __name__ == '__main__':
    unittest.main()