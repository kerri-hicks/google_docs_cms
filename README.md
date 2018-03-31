# google_docs_cms
Pull the contents of a Google doc into a PHP page.

Here's what you need to do to make this work:

1. Grab the index.php file and put it on a web server that's running PHP.
2. Create a Google Doc, copy the URL of that document, and paste it in as the value of $google_doc_url on line 6
3. Publish the Google Doc to the web, using File->Publish to the Web (or File->Advanced->Publish to the web), copy that URL, and paste it in as the value of $published_doc_url on line 9
4. Save index.php and load your page in a web browser

NB: Any changes you make to the Google Doc will automatically propogate to your new document -- but it may take up to five minutes for the changes to display.
