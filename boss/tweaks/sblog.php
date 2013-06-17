<?php
/* Author: awolfe (wolfe@ucsc.edu)
 * Description: This is a very simple blog tweak.
 * Credits:
 *      Thank you Zorchenhimer for your news tweak,
 *      it helped me a lot to get started.
 *
 *      Thank you Kalyan for developing NanoCMS,
 *      it kicks ass.
 * Disclaimer: 
 *      I cannot guarantee the behaviour of this code,
 *      use it at your own risk.
 * Legal:
 *  Copyright 2009 Alexander Wolfe
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *      
 */

$sblog = new Tweak( "Simple Blog" );
$sblog->author("awolfe");
$sblog->description("A simple blog tweak");
$sblog->addInterface('sblog_options');
$sblog->addTweak('sblog-page', 'sblog_show_posts');

define('SBLOG_POSTDIR', NANO_TWEAKS_DIR.'sblog/posts/');

//writes a new post to file
function sblog_put_post($title, $date, $content) {
    $filename_time = strtotime($date);
    $filename_title = str_replace(" ","_",$title);
    $filename_to_put = $filename_time."<::>".$filename_title.".html";
    $retval = put2file(SBLOG_POSTDIR.$filename_to_put, stripslashes($content));
    if(!$retval) {
        echo '<div class="redbox">Error writing file! Please check directory permissions.</div>';
    }
}

//displays content of all stored posts
function sblog_show_posts() {
    foreach(array_reverse(glob(SBLOG_POSTDIR."*.html")) as $postfile) {
        $stripleft = str_replace(SBLOG_POSTDIR,"",$postfile);
        $stripped = str_replace(".html","",$stripleft);
        $postinfo = explode("<::>",$stripped);
        $pulled_title = str_replace("_"," ",$postinfo[1]);
        $pulled_date = date("m/d/Y h:iA", $postinfo[0]);
        echo '<h2>'.$pulled_title.'</h2>';
        echo '<h5>'.$pulled_date.'</h5>';
        readfile($postfile);
        echo '<br/>';
    }
}

//sblog administrative page
function sblog_options() {
    echo '<div style="float: left;" >';
    $error = false;
    if($_POST['posted']) {
        $message = array();
        if(!($title = $_POST['ptitle'])) {
            $message['notitle'] = '<div class="redbox">Your post needs a title!</div>';
            $error = true;
        }
        if(!($date = $_POST['pdate'])) {
            $message['nodate'] = '<div class="redbox">Your post needs a date!</div>';
            $error = true;
        }
        if(!($content = $_POST['pcontent'])) {
            $message['nocontent'] = '<div class="redbox">Your post needs content!</div>';
            $error = true;
        }
        if(!$error) {
            sblog_put_post($title, $date, $content);
            sblog_show_post_table();
            sblog_show_links();
        }
        else {
            sblog_show_post_table();
            foreach ($message as $thiserror) {
                echo $thiserror;
            }
            $oldtitle = $title;
            $oldcontent = $content;
            sblog_show_post_form($oldtitle, $oldcontent);
        }
    }
    else if($_GET['del']) {
        $dfilename = SBLOG_POSTDIR.$_GET['del'].".html";
        $retval = unlink($dfilename);
        sblog_show_post_table();
        if(!$retval) {
            echo '<div class="redbox">Error deleting '.$dfilename.'</div>';
            sblog_show_links();
        }
        else {
            sblog_show_links();
        }
    }

    else if($_GET['newpost']) {
        sblog_show_post_table();
        sblog_show_post_form();
    } 
    else if($_GET['delconfirm']) {
        sblog_show_post_table();
        $dpostinfo = explode("<::>",$_GET['delconfirm']);
        $dtitle = str_replace("_"," ",$dpostinfo[1]);
        $dfilename = SBLOG_POSTDIR.$dpost.".html";
        echo '<div class="redbox">Are you sure you want to delete the post "'.$dtitle.'" ? <a href="?tweak=simple-blog&del='.$_GET['delconfirm'].'">Yes</a> / <a href="?tweak=simple-blog">No</a></div>';

    }
    else if($_GET['edit']) {
        sblog_show_post_table();
        $epost = $_GET['edit'];
        $epostinfo = explode("<::>",$epost);
        $etitle = str_replace("_"," ",$epostinfo[1]);
        $edate = date("m/d/Y h:iA", $epostinfo[0]);
        $efilename = SBLOG_POSTDIR.$epost.".html";
        if(!($econtent = file_get_contents($efilename))) {
            sblog_show_links();
            echo '<div class="redbox">Error opening '.$efilename.'</div>';
        }
        else {
            sblog_show_post_form($etitle, $econtent, $edate);
        }
    }
    else if($_GET['mainpage']) {
        sblog_show_post_table();
        $newp = new Page();
	    $newp->newPageInit();
	    $newp->addToCat( 'sidebar' );
        $newp->editTitle( 'Blog ' );
        $slug = $newp->slug;
        $newp_file = pageDataDir($slug);
        $mainpage_content = "<?php runTweak('sblog-page') ?>";
        if(!file_exists($newp_file)) {
            $newp->commitChanges();
            runTweak( 'new-page', array( 'page-obj'=>&$newp, 'page-content'=> &$mainpage_content ) );
            if(!(put2file($newp_file, $mainpage_content))) {
                sblog_show_links();
                echo '<div class="redbox">Error writing file!</div>';
            }
            else {
                savepages();
            }
            sblog_show_links();
        }
        else {
            sblog_show_links();
            echo '<div class="redbox">File already exists!</div>';
        }
    }
    else {
        sblog_show_post_table();
        sblog_show_links();
    }
    echo '</div>';
}

//displays the links bar (ie. new post, etc...)
function sblog_show_links() {
    echo'<a href ="?tweak=simple-blog&newpost=true">New Post</a> | ';
    echo'<a href ="?tweak=simple-blog&mainpage=true">Add Blog to Pages</a>';
    echo '<br/>';
}

//displays the form for adding a new post
function sblog_show_post_form($oldtitle="", $oldcontent="", $olddate="") {
    if ($olddate == "") {
        $olddate = date('m/d/Y h:iA');
    }
    runTweak('add-form-display');
    echo '
    <object><form action="admin.php?tweak=simple-blog" method="post">
            <label><b>Title:</b></label><br/>
            <input type="text" name="ptitle" value="'.$oldtitle.'"/><br/>
            <label><b>Date/Time:</b></label><br/>
            <input type="text" name="pdate" value="'.$olddate.'"/><br/>
            <textarea rows="10" cols="80" name="pcontent">'.$oldcontent.'</textarea><br/>
            <input type="submit" value="Post" name="posted" /> <a href="?tweak=simple-blog">Cancel</a><br/>
        </form></object>
        ';
    runTweak('after-add-form-display');
}

//displays a table of all titles, date, and filenames of stored posts
function sblog_show_post_table() {
    echo '
        <table>
        <thead style="background: #C3D9FF;">
            <tr><td>Title</td><td>Date</td></tr>
        </thead>
        <tbody>
         ';
    foreach(glob(SBLOG_POSTDIR."*.html") as $postfile) {
        $filename = $postfile;
        $stripl = str_replace(SBLOG_POSTDIR,"",$postfile);
        $stripped = str_replace(".html","",$stripl);
        $postinfo = explode("<::>",$stripped);
        $pulled_title = str_replace("_"," ",$postinfo[1]);
        $pulled_date = date("m/d/Y", $postinfo[0]);
        echo '
            <tr><td>'.$pulled_title.'</td><td>'.$pulled_date.'</td>
            <td><a href="?tweak=simple-blog&edit='.$stripped.'">Edit</a></td>
            <td><a href="?tweak=simple-blog&delconfirm='.$stripped.'">Delete</a></td></tr>';
    }
    echo '
        </tbody>
        </table>
        ';
}
?>

