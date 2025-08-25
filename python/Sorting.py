import pandas as pd
import findTheDistance as ftd


def sort_recommended_list(input_data_html, compared_result, preferences):

  if isinstance(preferences, str): 
    preferences = [preferences]

  df = compared_result.copy()

  # 2.4.1 Location (State)
  if "location" in preferences:
    # Sort by state or area

    print("The user choose location. Starting the location preferences")

    locations = input_data_html.get("location", [])
    if isinstance(locations, str): 
      locations = [locations]
    df = df[df["state_name"].isin(locations)]
    print(df)
    print("Done the Sorting by location")

  # # 2.4.2 Area of Interest 
  if "area_of_interest" in preferences:
    # Sort by area of interest (assuming 'course_category' is the area of interest)

    print("The user choose Area of interest. Starting the Area of Interest preferences")
    
    area_interests = input_data_html.get('area_of_interest', [])
    if isinstance(area_interests, str): 
      area_interests = [area_interests]
    df = df[df["course_aspect"].isin(area_interests)]

    print("Done for the sorting by Area of interest")

  # # 2.4.3 Expected Total Tuition Fees 
  if "expected_fees" in preferences:
    # Sort by tuition fees

    print("The user choose expected_fees. Starting the expected preferences")
    
    tuition_fees_start = float(input_data_html.get('tuition_fees_start', 0))
    tuition_fees_end = float(input_data_html.get('tuition_fees_end', 0))
    df = df[(df['tuition_fees'] >= tuition_fees_start) & (df['tuition_fees'] <= tuition_fees_end)]
    df = df.sort_values(by="tuition_fees")

    print("Done for the sorting by expected tuition fees")
    
    # print(f"Sorted result by Expected Tuition Fees: {new_recommended_list['id']} {new_recommended_list['tuition_fees']}")

  # # 2.4.4 Shortest Distance
  if "shortest_distance" in preferences:

    print("The user choose Shortest distance")

    input_address = f"{input_data_html['address']}, {input_data_html['area']}, {input_data_html['state']}, Malaysia"
    distances = []

    for _,row in df.iterrows(): 
      uni_address = f"{row['uni_address']}, {row['area_name']}, {row['state_name']}, Malaysia"
      distances.append(ftd.find_the_distance_V3(uni_address, input_address))

    df = df.copy()
    df["distance"] = distances
    df = df.sort_values(by="distance")

    print("Done the sorting of the distance")

  # 2.5 if the preferences is not selected
  if not preferences or df.empty:
    df = compared_result.sort_values(by="ranking_qs_no_start")
    print("Applied default QS ranking sort")

  print("The new recommendation list is generated")

  return df.to_dict(orient="records")