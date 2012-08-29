# Eden PHP Library 
##Designed for rapid prototyping, with less code.

Eden is purely a library packed with core concepts and web services. You can use Eden on top of any CMS or framework you choose. At Openovate Labs, we use Eden for all of our internal products which in turn keeps Eden updated, evolving and constantly expanding. Eden takes advantage of PHP 5.3 with the tools available to get products made faster. Eden works with major players including:

* Google
* Facebook
* Twitter
* Tumblr
* Four Square
* Get Satisfaction
* Eventbrite
* Zappos
* Web Charge
* Paypal
* Authorize.net
* Amazon
* Jabber

#Contibuting to Eden

##Setting up your machine with the Eden repository and your fork

1. Fork the main Eden repository (https://github.com/Openovate/eden)
2. Fire up your local terminal and clone the *MAIN EDEN REPOSITORY* (git clone git://github.com/Openovate/eden.git)
3. Add your *FORKED EDEN REPOSITORY* as a remote (git remote add fork git@github.com:*github_username*/eden.git)

##Making pull requests

1. Before anything, make sure to update the *MAIN EDEN REPOSITORY*. (git checkout master; git pull origin master)
2. Once updated with the latest code, create a new branch with a branch name describing what your changes are (git checkout -b bugfix/fix-twitter-auth)
    Possible types:
    - bugfix
    - feature
    - improvement
3. Make your code changes. Always make sure to sign-off (-s) on all commits made (git commit -s -m "Commit message")
4. Once you've committed all the code to this branch, push the branch to your *FORKED EDEN REPOSITORY* (git push fork bugfix/fix-twitter-auth)
5. Go back to your *FORKED EDEN REPOSITORY* on GitHub and submit a pull request.
6. An Eden developer will review your code and merge it in when it has been classified as suitable.
