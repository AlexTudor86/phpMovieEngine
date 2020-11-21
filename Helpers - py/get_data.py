import requests
import mysql.connector

url_top_rated = 'https://api.themoviedb.org/3/movie/top_rated'
url_img = 'https://image.tmdb.org/t/p/w500'
api_key = 'please request a free api key'

''' Dictionarul genre creat prin get_genre.py
A fost adaugat cu copy-paste, dar putea fi salvat ca json si importat'''
genre = {
 10752: 'War',
 80: 'Crime',
 10402: 'Music',
 35: 'Comedy',
 36: 'History',
 37: 'Western',
 53: 'Thriller',
 9648: 'Mystery',
 12: 'Adventure',
 10770: 'TV Movie',
 14: 'Fantasy',
 16: 'Animation',
 18: 'Drama',
 99: 'Documentary',
 878: 'Science Fiction',
 27: 'Horror',
 28: 'Action',
 10749: 'Romance',
 10751: 'Family'
 }

class Movie:
    
    def __init__(self, movie_json):
        self.info = {
            'titlu': movie_json['title'],
            'gen': ", ".join(map(lambda x: genre[x], movie_json['genre_ids'])), # un film poate avea id de action si id de horror
            'an': movie_json['release_date'].split('-')[0],
            'voturi': movie_json['vote_count'],
            'nota': movie_json['vote_average'],
            'descriere': movie_json['overview'],
            }


conn_params = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    }
conn = mysql.connector.connect(**conn_params)
cursor = conn.cursor()

create_db_str = "CREATE DATABASE proiect_Alex_Tudor"

create_table_str = ("CREATE TABLE filme ("
                    " id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,"
                    " titlu VARCHAR(255) NOT NULL,"
                    " gen VARCHAR(255) NOT NULL,"
                    " an SMALLINT NOT NULL,"
                    " voturi SMALLINT NOT NULL,"
                    " nota FLOAT NOT NULL,"
                    " descriere TEXT)"
                    "CHARACTER SET utf8"
                    )

cursor.execute(create_db_str)
cursor.execute("USE proiect_Alex_Tudor")
cursor.execute(create_table_str)


params = { 'api_key': api_key }
for i in range(1, 400): # API-ul ne pune la dispozitie doar 399 pagini din sectiunea top_rated
    params['page'] = i
    resp = requests.get(url_top_rated, params=params)
    data = resp.json()
    for movie_details in data['results']:
        data_str = ("INSERT INTO filme(titlu, gen, an, voturi, nota, descriere) VALUES "
                "(%(titlu)s, %(gen)s, %(an)s, %(voturi)s, %(nota)s, %(descriere)s)")
        movie = Movie(movie_details)
        cursor.execute(data_str, movie.info)

conn.commit()
cursor.close()
conn.close()
    
