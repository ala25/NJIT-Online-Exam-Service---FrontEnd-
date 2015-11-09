from bs4 import BeautifulSoup
import requests

url = "http://facebook.com"
r = requests.get(url)
soup = BeautifulSoup(r.text,'lxml')

for t in soup:
	print(t)