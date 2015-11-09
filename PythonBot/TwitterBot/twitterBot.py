import tweep
class TwitterAPI:
    def __init__(self):
        consumer_key = "jDtoeXv7e5AFpxwXOWgjYPpC3"
        consumer_secret = "6DH42jACx3lc0aucyW25mucClsy9qQzLAHfwtRN9ncOgGSZ7iH"
        auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
        access_token = "24048591-tGAvvMMKph1VdTjKFPMWORPVFqjihldzHB0c2pKzx"
        access_token_secret = "1uXU4iXhvuAmITG6JZ0GElmW5pcrJc2QNeHWLcdAB8sao"
        auth.set_access_token(access_token, access_token_secret)
        self.api = tweepy.API(auth)

    def tweet(self, message):
        self.api.update_status(status=message)

    def timeLine(self):
        list = self.api.home_timeline()
        return list

if __name__ == "__main__":
    twitter = TwitterAPI()
    timeLine = twitter.timeLine()
    for obj in timeLine:
        print obj
    