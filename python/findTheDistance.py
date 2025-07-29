
from geopy.geocoders import Nominatim 
from geopy.distance import geodesic

import googlemaps

def find_the_distance_V1():
    # using googlemaps (cannot do)

    # home address input from the generate university list file 
    input_address = "Taragon Puteri Cheras, 43200 Cheras, Selangor"

    # dataset from the generate university list file
    dataset_address = "Jalan Sungai Long, Bandar Sungai Long, 43000 Kajang, Selangor"

    gmaps = googlemaps.Client(key="YOUR_GOOGLE_MAPS_API_KEY")

    distance = gmaps.distance_matrix(input_address, dataset_address, mode="driving")

    print(distance)

    return distance

def find_the_distance_V2(): 

    input_address = "Taragon Puteri Cheras, 43200 Cheras, Selangor"

    # dataset from the generate university list file
    dataset_address = "Jalan Sungai Long, Bandar Sungai Long, 43000 Kajang, Selangor"

    geolocator = Nominatim(user_agent="distance_calculator")

    location1 = geolocator.geocode(input_address)
    location2 = geolocator.geocode(dataset_address)

    coords_1 = (location1.latitude, location1.longitude)
    coords_2 = (location2.latitude, location2.longitude)

    distance = geodesic(coords_1, coords_2).kilometers

    print(distance)

    return distance

if __name__ == "__main__":
    
    find_the_distance_V1()
    # find_the_distance_V2()


    
    # calculate the distance 




    # output to the list 