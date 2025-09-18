import unittest
from unittest.mock import patch, MagicMock
import pandas as pd
import CollectionDataFromDatabase

class TestCollectionData(unittest.TestCase):

    @patch("CollectionDataFromDatabase.mysql.connector.connect")
    def test_collection_data_from_database(self, mock_connect):
        # Setup mock connection and cursor
        mock_connection = MagicMock()
        mock_cursor = MagicMock()

        mock_connect.return_value = mock_connection
        mock_connection.cursor.return_value = mock_cursor

        # Fake query results
        mock_cursor.description = [
            ("id",), ("course_honour_name",), ("tuition_fees",), ("uni_name",)
        ]
        mock_cursor.fetchall.return_value = [
            (1, "BSc Computer Science", 12000, "Uni A"),
            (2, "BA Economics", 10000, "Uni B"),
        ]

        # Call function
        df = CollectionDataFromDatabase.collection_data_from_database()

        # Assertions
        self.assertIsInstance(df, pd.DataFrame)
        self.assertEqual(len(df), 2)
        self.assertIn("course_honour_name", df.columns)
        self.assertEqual(df.iloc[0]["uni_name"], "Uni A")

        # Ensure cleanup
        mock_cursor.close.assert_called_once()
        mock_connection.close.assert_called_once()


if __name__ == "__main__":
    unittest.main()