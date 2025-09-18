import unittest
from CollectionDatafromHTML import app
import json

class FlaskAppTestCase(unittest.TestCase):

    def setUp(self):
        # Initialize the test client
        self.client = app.test_client()
        self.client.testing = True


    # Integration Test
    def test_final_submit_success(self):
        # Sample data to simulate Laravel frontend input
        sample_data = {
            'name': 'Ali Muhammad', 
            'address': 'Setia Sky Residences, Jalan Raja Muda Abdul Aziz', 
            'postcode': '50300', 
            'area': 'Kuala Lumpur', 
            'state': 'Wilayah Persekutuan Kuala Lumpur', 
            'subjects': [
                {
                    'name': 'Pengajian Am', 
                    'marks': '3.92'
                }, 
                {
                    'name': 'Mathematics (T)', 
                    'marks': '3.75'
                },
                {
                    'name': 'Chemistry', 
                    'marks': '4.00'
                }, 
                {
                    'name': 'Physics', 
                    'marks': '3.64'
                }], 
            'MUETmarks': '4.5', 
            'cocuriculummarks': '99', 
            'unitype': 'public', 
            'preference': [
                'location', 
                'shortest_distance', 'area_of_interest', 'expected_fees'
                ], 
            'location': [
                'Pulau Pinang', 
                'Wilayah Persekutuan Kuala Lumpur'], 
            'area_of_interest': [
                'Engineering', 
            'Information Technology'], 
            'tuition_fees_start': '10000', 
            'tuition_fees_end': '90000'
        }

        response = self.client.post(
            "/final_submit",
            data=json.dumps(sample_data),
            content_type='application/json'
        )

        self.assertEqual(response.status_code, 200)
        json_data = response.get_json()
        # Ensure the response is a list (recommendations)
        self.assertIsInstance(json_data, list)

    def test_final_submit_invalid_data(self):
        # Sending invalid data (e.g., string instead of JSON)
        response = self.client.post(
            "/final_submit",
            data="invalid data",
            content_type='application/json'
        )

        # Should return 500 error due to exception handling
        self.assertEqual(response.status_code, 500)
        json_data = response.get_json()
        self.assertIn("error", json_data)

if __name__ == "__main__":
    unittest.main()
