import requests


api_key = 'please request a free api key'
url = 'https://api.themoviedb.org/3/genre/movie/list'

params = {'api_key': api_key}
resp = requests.get(url, params=params)

list_genres = resp.json()['genres']

list_ids = map(lambda genre: {genre['id']: genre['name']}, list_genres)
ids_dict = {}

for i in range(len(list_ids)):
    for k, v in list_ids[i].items():
        ids_dict[k] = v

for k, v in ids_dict.items():
    print k, '--->', v

''' Alternativ

import json

with ('genres.json', 'w') as f:
    f.write(json.dumps(ids_dict))
    
'''
