# instafreight_task

Please open the folder solutions for question 2 and question 3. I used lib folder for question 2.

## Question 1 - Route decoder (AKA JS port)

I have used [ord()](http://php.net/manual/en/function.ord.php) for Javascript function - charCodeAt() . I did not follow the coding standard what I used for other questions.

## Question 2 - r/UpliftingNews consumer 
I used CURL to fetch data from the API.

We want to display news on the front page for our customers... We want to display only good news because they spend more money if they are happier... For that we'll use a r/UpliftingNews

### 1. What further improvements would you implement?

To get good news our customers I prefer to apply [Sentiment Analysis](https://en.wikipedia.org/wiki/Sentiment_analysis). I had a plan to make an electron application for Ubuntu. It was a new reader application. It will daily fetch the news from different resources. There would be text-speech to read the news. So there was an option to read the only good news. I have started learning Electron, but due to the office work, I didn't get time to implement it. So for grabbing good news, I wanted to use sentiment analysis.
Sentiment analysis seeks to solve this problem by using natural language processing to recognize keywords within a document and thus classify the emotional status of the piece.

[http://www.memetracker.org](http://www.memetracker.org) is used Sentiment Analysis.

Basic sentiment analysis algorithms use natural language processing (NLP) to classify documents as positive, neutral, or negative.

For for this quick task, I prefer [https://github.com/JWHennessey/phpInsight](https://github.com/JWHennessey/phpInsight).

### 2. What can we do in order to reduce requests? Many users are visiting the homepage and it's becoming slow..

To reduce requests, From my experience and knowledge

1) Move JavaScript files from head section to footer section.
2) Reduce the number of files(css, js, images, videos). We can use CDN too.
3) Minify/Compress JavaScript and CSS files and combine CSS & JS files together for common functionalities.
4) Optimize image size.
5) Make asynchronous calls.
6) If you have APIs, create very simple APIs. Don't create complicated APIs by making unwanted requests and reponses.
7) Code optimizations, remove unwanted lines. Try to reduce number of lines from scripts.
8) Database query optimization, If you are using RDMS, you have to optimize the query.
9) Cache static and dynamic content. Also we can use some server side caching too.
10) Load balancing.
11) Optimize SSL/TLS (Session caching, Session tickets or IDs , OCSP stapling).
12) Implement HTTP/2 or SPDY.
13) Tune server OS for performance


## Question 3 - Keyword extractor
For SEO, it would conisder UPPERCASE, Propercase, CamelCase and lowercase words are same.
