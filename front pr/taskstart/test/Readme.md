# Setup your env
* ``cd`` to the directory of this test-package
* Make sure docker is installed and running
* Run ``docker run -d --name=apache-php --restart=always -p 80:80 -v "$PWD/files":/var/www/html chriswayg/apache-php``
* Make sure you can access [http://localhost](http://localhost)
* Ensure that changes to the files at ``./files`` are synced with the VM

# Your task

## Rules
* You are entitled to install any software on the VM that you may need, tho please note this down for me to reconstruct
* It's totally allowed to copy code from wherever you want(stackoverflow, google...)
    * Tho, please provide references via comments
* The test is rather about the path you choose than the result in the end, which does - of course - not mean the result doesn't matter

## The actual task
* Please create a website that consists of 2 pages
    * http://localhost/ - the homepage
        * On this website place a red rectangle in the middle of the browser-tab(width=20%, height=20%)
            * On a mobile device(tablet + phone) place the given rectangle on the top of the page
    * http://localhost/yay - a second page with a slider
        * Please place a slider on this page
        * Use the images from ``./files/img`` in the given order
    * All pages
        * Add a navigation to the pages that allows to switch between the pages
        * Add a sticky(sticky, only on desktop) footer to the bottom of the page that states "Target Traffic LTD"
        * Include jQuery - latest - no matter if you intent to use it
    * Future scenario
        * just imagine that the given website will soon be extended by 10 more pages in the same layout(footer, navi)

# Hints
* Read again through the job profile
* Check all files that have been provided
* The given image is a Debian linux
* If you need to do modifications to the image it's totally fine if you do these via ssh
    * You can ssh via ``bash -c "clear && docker exec -it apache-php sh"``
    * If you know what you are doing, feel free to handle it in the docker file 
* Keep in mind that we want google/search engines to LOVE this page
* You don't have to use the given docker image if you decide to not use apache/php, tho you are strongly encouraged to use docker
* Keep in mind that there is no "over engineering" here, since its a presentation of your skills and how you (would like to) work
