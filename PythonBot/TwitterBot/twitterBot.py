import tweepy
class TwitterAPI:
    def __init__(self):
        consumer_key = ""
        consumer_secret = ""
        auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
        access_token = ""
        access_token_secret = ""
        auth.set_access_token(access_token, access_token_secret)
        self.api = tweepy.API(auth)

    def tweet(self, message):
        self.api.update_status(status=message)

    def timeLine(self):
        list = self.api.home_timeline()
        return list

    def trends(self,loc):
        trends = self.api.trends_place(loc)
        return trends

if __name__ == "__main__":
    twitter = TwitterAPI()
    timeLine = twitter.timeLine()
    globalTrends = twitter.trends(1)
    for obj in globalTrends:
        for s in obj[u'trends']:
            print s[u'name']
        

    