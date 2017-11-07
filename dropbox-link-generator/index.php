<?php include('nav.html'); ?>
<div class="container theme-showcase" role="main">

    <div class="jumbotron">
        <h1>DropBox Link Generator </h1>
        <p><i><b>Description:</b> Free dropbox direct link generator. How to create a download link dropbox? Share your link for free! How to download from dropbox? Dropbox shared folder generator! Share a dropbox folder! Dropbox file sharing - try it for free! Create a link to share any file in your Dropbox.</i></p>
        <div id="number">
            <label for="textarea_url">Insert your dropbox URL here:</label><br>
            <textarea class="form-control" rows="8" cols="90" name="dropbox_url" id="textarea_url" placeholder="Enter Your Links Here..." autofocus></textarea>
            <label><input id="raw" type="checkbox" name="raw" value="raw" checked /> RAW url </label>
            <label><input id="bbimg" type="checkbox" name="bbimg" value="bbimg" checked /> BBCode img </label>
            <label><input id="bburl" type="checkbox" name="bburl" value="bburl" checked /> BBCode url </label>
            <label><input id="htmlimg" type="checkbox" name="htmlimg" value="htmlimg" checked /> HTML img </label>
            <label><input id="htmla" type="checkbox" name="htmla" value="htmla" checked /> HTML a </label>
            <label><input id="allurl" type="checkbox" name="allurl" value="allurl" checked /> All url </label>
            <br>
            <button type="submit" class="btn btn-success" onclick="return checkTextArea();">Generate link</button>
        </div>
    </div>
    <div class="center_fb">
        <div class="fb-like" data-href="http://dropbo.haker.edu.pl/index.php" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-fw fa-check"></i><span class="glyphicon glyphicon-share-alt"></span> Dropbox share link</h2>
                </div>
                <div class="panel-body">
                    <img src="/img/drropbox-share-link.png" width="128" height="128" alt="Dropbox share link">Share your files with friends!

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-fw fa-gift"></i><span class="glyphicon glyphicon-screenshot"></span> Dropbox direct link </h2>
                </div>
                <div class="panel-body">
                    <img src="/img/dropbox-direct-link.png" width="128" height="128" alt="Dropbox direct link">Get a direct link to the file.

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="medium"><i class="fa fa-fw fa-compass"></i><span class="glyphicon glyphicon-download-alt"></span> Dropbox public folder</h2>
                </div>
                <div class="panel-body">
                    <img src="/img/dropbox-public-directory.png" width="128" height="128" alt="Dropbox public folder">Download links from folder.
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.html'); ?>
</body>
</html>