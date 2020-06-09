<?php
	// Date Last Modified: 2020-02-01
	// Module:             db_utils.php
	// Object:             Connect to system DB
	// Return:             void
	//
	//
	// Copyright (c) 2020, Texas A&M University-Corpus Christi, Corpus Christi, TX
	// All rights reserved.
	//
	// Redistribution and use in source and binary forms, with or without modification, are permitted provided that 
	// the following conditions are met:
	//
	// 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the 
	//    following disclaimer.
	//
	// 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the 
	//    following disclaimer in the documentation and/or other materials provided with the distribution.
	//
	// 3. Neither the name of the EarthCube X-DOMES nor the names of its contributors, module developers and project
	//    members may be used to endorse or promote products derived from this software without specific prior written
	//    permission.
	//
	// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
	// INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE 
	// DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, 
	// SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR 
	// SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, 
	// WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE 
	// USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.	

session_start();
if ( isset( $_GET[ "order" ] ) )$order = @$_GET[ "order" ];
if ( isset( $_GET[ "type" ] ) )$ordtype = @$_GET[ "type" ];

if ( isset( $_POST[ "filter" ] ) )$filter = @$_POST[ "filter" ];
if ( isset( $_POST[ "filter_field" ] ) )$filterfield = @$_POST[ "filter_field" ];
$wholeonly = false;
if ( isset( $_POST[ "wholeonly" ] ) )$wholeonly = @$_POST[ "wholeonly" ];

if ( !isset( $order ) && isset( $_SESSION[ "order" ] ) )$order = $_SESSION[ "order" ];
if ( !isset( $ordtype ) && isset( $_SESSION[ "type" ] ) )$ordtype = $_SESSION[ "type" ];
if ( !isset( $filter ) && isset( $_SESSION[ "filter" ] ) )$filter = $_SESSION[ "filter" ];
if ( !isset( $filterfield ) && isset( $_SESSION[ "filter_field" ] ) )$filterfield = $_SESSION[ "filter_field" ];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<title>X-DOMES: SensorML Registry and Repository</title>
<link href="css/xdomes.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script>
        $( function() {
        $( "#tabs" ).tabs();
        } );
        </script>
</head>

<body>
<!-- <div class="container"> -->
<?php
include "header.php";
?>
<div class="content"> 
  <!-- start .content -->
  <p>The <em>X-DOMES' SensorML Registry and Repository</em> (SRR) is a facility to centrally archive SensorML records to facilitate access. Although the SRR is a prototype and proof of concept developed by the X-DOMES project, the system is actively managed and open for all to use and evaluate. </p>
  <hr />
  <div id="tabs" style="margin-left:20px; margin-right:20px">
    <ul>
      <li><a href="#records">Records</a></li>
      <li><a href="#howto">How to ...</a></li>
    </ul>
    <div id="records">
      <div style="margin-left:20px">
        <?php
        global $conn;
        $conn = connect();
        $showrecs = 20000;
        $pagerange = 20;

        $a = @$_GET[ "a" ];
        $page = @$_GET[ "page" ];
        if ( !isset( $page ) ) {
          $page = 1;
        }

        select();

        if ( isset( $order ) ) {
          $_SESSION[ "order" ] = $order;
        }
        if ( isset( $ordtype ) ) {
          $_SESSION[ "type" ] = $ordtype;
        }
        if ( isset( $filter ) ) {
          $_SESSION[ "filter" ] = $filter;
        }
        if ( isset( $filterfield ) ) {
          $_SESSION[ "filter_field" ] = $filterfield;
        }
        if ( isset( $wholeonly ) ) {
          $_SESSION[ "wholeonly" ] = $wholeonly;
        }

        $conn = null;
        ?>
      </div>
    </div>
    <!-- end .records tab -->
    
    <div id="howto">
      <p><strong>Direct Access of a Record</strong></p>
      <blockquote>
        <p>The <em>SensorML</em> files records can be accessed directly using the following syntax: </p>
        <blockquote>
          <p><tt>https://xdomes.org/srr/sensorML.php?urn={<span class="subtitle"><em>enter the URN of the record on file</em></span>}</tt></p>
          <p><em>Example</em>:</p>
          <p><a href="https://xdomes.org/srr/sensorML.php?urn=urn:whoi:mvco:mvco_workhorse_1200" target="_blank"><tt>https://xdomes.org/srr/sensorML.php?urn=urn:whoi:mvco:mvco_workhorse_1200</tt></a></p>
        </blockquote>
        <p>Alternatively, if the direct filename is available (the ':' characters are replaced with '-'), a direct HTTP call (i.e. API-less) can also be used to access the SensorML file.</p>
        <blockquote>
          <p>Example:</p>
          <p><a href="https://xdomes.org/srr/sensorML/urn-whoi-mvco-mvco_workhorse_1200.xml" target="_blank"><tt>https://xdomes.org/srr/sensorML/urn-whoi-mvco-mvco_workhorse_1200.xml</tt></a></p>
        </blockquote>
      </blockquote>
      <p><strong>Query the Registry</strong></p>
      <blockquote>
        <p>The <em>SensorML</em> files in the registry can be queries using the following syntax: </p>
        <blockquote>
          <p><tt>https://xdomes.org/srr/sensorML.php?query={<span class="subtitle"><em>enter query term</em></span>}&attribute={<span class="subtitle"><em>enter attribute to search (e.g. description)</em></span>}</tt></p>
          <p><em>Example</em>:</p>
          <p><a href="https://xdomes.org/srr/sensorML.php?query=RD&amp;attribute=description" target="_blank"><tt>https://xdomes.org/srr/sensorML.php?query=RD&amp;attribute=description</tt></a></p>
        </blockquote>
      </blockquote>
      <p>&nbsp;</p>
    </div>
    <!-- end .howto tab --> 
  </div>
  <!-- end .tab --> 
</div>
<!-- end .content -->
<?php
include "footer.php";
?>
</body>
</html>
<?php
#this is the start of the codes

function connect() {
  $db = $_SERVER[ 'DOCUMENT_ROOT' ] . $db;
  try {
    $dbh = new PDO( "sqlite:" . $db );
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  } catch ( PDOException $e ) {
    $dbh->rollBack();
    echo "Error!" . $e->getMessage() . "<br/>";
    die();
  }

  return $conn;
}

function select() {
  global $a;
  global $showrecs;
  global $page;
  global $filter;
  global $filterfield;
  global $wholeonly;
  global $order;
  global $ordtype;

  if ( $a == "reset" ) {
    $filter = "";
    $filterfield = "";
    $wholeonly = "";
    $order = "";
    $ordtype = "";
  }

  $checkstr = "";
  if ( $wholeonly )$checkstr = " checked";
  if ( $ordtype == "asc" ) {
    $ordtypestr = "desc";
  } else {
    $ordtypestr = "asc";
  }
  $res = sql_select();
  $count = sql_getrecordcount();
  if ( $count % $showrecs != 0 ) {
    $pagecount = intval( $count / $showrecs ) + 1;
  } else {
    $pagecount = intval( $count / $showrecs );
  }
  $startrec = $showrecs * ( $page - 1 );
  $startrec = $startrec - 1;
  $reccount = min( $showrecs * $page, $count );
  ?>
<!-- the following is a mixed php+html codes -->

<table class="bd" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#CCCCCC">
    <td>Total Number of Records:<?php echo $count ?></td>
  </tr>
</table>
<hr size="1" noshade/>
<form action="index.php" method="post">
  <table class="bd" border="0" cellspacing="1" cellpadding="4" width="100%">
    <tr>
      <td width="230px"><b>Enter the word to filter the list:</b>&nbsp;</td>
      <td width="150px"><input type="text" name="filter" value="<?php echo $filter ?>"></td>
      <td width="130px"><select name="filter_field">
          <option value="">All Fields</option>
          <option value="<?php echo "Organization" ?>"<?php if ($filterfield == "Organization") { echo "selected"; } ?>><?php echo htmlspecialchars("Organization") ?></option>
          <option value="<?php echo "Project" ?>"<?php if ($filterfield == "Project") { echo "selected"; } ?>><?php echo htmlspecialchars("Project") ?></option>
          <option value="<?php echo "URN" ?>"<?php if ($filterfield == "URN") { echo "selected"; } ?>><?php echo htmlspecialchars("URN") ?></option>
          <option value="<?php echo "Description" ?>"<?php if ($filterfield == "Description") { echo "selected"; } ?>><?php echo htmlspecialchars("Description") ?></option>
          <option value="<?php echo "SensorML" ?>"<?php if ($filterfield == "SensorML") { echo "selected"; } ?>><?php echo htmlspecialchars("SensorML") ?></option>
          <option value="<?php echo "Contact" ?>"<?php if ($filterfield == "Contact") { echo "selected"; } ?>><?php echo htmlspecialchars("Contact") ?></option>
        </select></td>
      <td><input type="checkbox" name="wholeonly"<?php echo $checkstr ?>>
        Whole words only</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="action" value="Apply Filter"></td>
      <td><a href="index.php?a=reset">Reset Data Filter</a></td>
    </tr>
  </table>
</form>
<hr size="1" noshade/>
NOTE: Click on the header to sort the rows if desired.
<?php showpagenav($page, $pagecount); ?>
<br />
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
  <tr>
    <td class="hr"><a class="hr" href="index.php?order=<?php echo "Organization" ?>&type=<?php echo $ordtypestr ?>"><?php echo htmlspecialchars("Organization") ?></a></td>
    <td class="hr"><a class="hr" href="index.php?order=<?php echo "Project" ?>&type=<?php echo $ordtypestr ?>"><?php echo htmlspecialchars("Project") ?></a></td>
    <td class="hr"><a class="hr" href="index.php?order=<?php echo "URN" ?>&type=<?php echo $ordtypestr ?>"><?php echo htmlspecialchars("URN") ?></a></td>
    <td class="hr"><a class="hr" href="index.php?order=<?php echo "Description" ?>&type=<?php echo $ordtypestr ?>"><?php echo htmlspecialchars("Description") ?></a></td>
    <td class="hr"><a class="hr" href="index.php?order=<?php echo "Version" ?>&type=<?php echo $ordtypestr ?>"><?php echo htmlspecialchars("Version") ?></a></td>
    <td class="hr"><a class="hr" href="index.php?order=<?php echo "SensorML" ?>&type=<?php echo $ordtypestr ?>"><?php echo htmlspecialchars("SensorML") ?></a></td>
    <td class="hr"><a class="hr" href="index.php?order=<?php echo "Contact" ?>&type=<?php echo $ordtypestr ?>"><?php echo htmlspecialchars("Contact") ?></a></td>
  </tr>
  <?php
  for ( $i = $startrec; $i < ( $reccount - 1 ); $i++ ) {
    $row = sqlite_fetch_array_ex( $res );
    $style = "dr";
    if ( $i % 2 != 0 ) {
      $style = "sr";
    }
    ?>
  <tr>
    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["Organization"]) ?></td>
    <td width="100px" class="<?php echo $style ?>"><?php echo htmlspecialchars($row["Project"]) ?></td>
    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["URN"]) ?></td>
    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["Description"]) ?></td>
    <td width="80px" class="<?php echo $style ?>"><?php echo htmlspecialchars($row["Version"]) ?></td>
    <td class="<?php echo $style ?>"><?php

	$orig_chars = array(":",".");
	$new_chars  = array("-","_");

    $sml_id = str_replace( $orig_chars, $new_chars, $row[ "URN" ] );
    $url = "https://xdomes.org/srr/sensorML/" . $sml_id . ".html";
    echo '<a href=' . $url . ' target=_blank> Open </a>';
    ?></td>
    <td width="100px" class="<?php echo $style ?>"><?php
    echo '<a href=mailto:' . $row[ "Contact_Email" ] . '>' . $row[ "Contact" ] . '</a>'
    ?></td>
    
  </tr>
  <?php
  }
  ?>
</table>
<?php
showpagenav( $page, $pagecount );
}

function sql_select() {
  global $conn;
  global $order;
  global $ordtype;
  global $filter;
  global $filterfield;
  global $wholeonly;

  $filterstr = sqlstr( $filter );
  if ( !$wholeonly && isset( $wholeonly ) && $filterstr != '' )$filterstr = "%" . $filterstr . "%";
  $sql = "SELECT s.rowid as Record, p.organization as Organization, p.folder as Project, s.urn as URN, s.description as Description, s.sensonrML as sensorML, s.version as Version, s.contact_name as Contact, s.contact_email as Contact_Email FROM sensorML s JOIN projects p ON (s.project_id=p.rowid) JOIN registrant as r ON (p.reg_id=r.rowid) where s.valid=1";

  if ( isset( $filterstr ) && $filterstr != '' && isset( $filterfield ) && $filterfield != '' ) {
    $sql .= " and " . sqlstr( $filterfield ) . " like '" . $filterstr . "'";
  } elseif ( isset( $filterstr ) && $filterstr != '' ) {
    $sql .= " and (Organization like '" . $filterstr . "') or (Project like '" . $filterstr . "') or (URN like '" . $filterstr . "') or (Description like '" . $filterstr . "') or (sensorML like '" . $filterstr . "') or (Version like '" . $filterstr . "') or (Contact like '" . $filterstr . "') or (Contact_Email like '" . $filterstr . "') or (Registrant like '" . $filterstr . "')";
  }

  if ( isset( $order ) && $order != '' )$sql .= " order by \"" . sqlstr( $order ) . "\"";
  if ( isset( $ordtype ) && $ordtype != '' )$sql .= " " . sqlstr( $ordtype );

  $db = $_SERVER[ 'DOCUMENT_ROOT' ] . $db;
  try {
    $dbh = new PDO( "sqlite:" . $db );
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  } catch ( PDOException $e ) {
    $dbh->rollBack();
    echo "Error!" . $e->getMessage() . "<br/>";
    die();
  }

  $res = $dbh->query( $sql );
  $dbh->null;
  #$res = $conn->query($sql);
  return $res;
}

function sql_getrecordcount() {
  global $conn;
  global $order;
  global $ordtype;
  global $filter;
  global $filterfield;
  global $wholeonly;

  $filterstr = sqlstr( $filter );
  if ( !$wholeonly && isset( $wholeonly ) && $filterstr != '' )$filterstr = "%" . $filterstr . "%";
  $sql = "SELECT COUNT(*) FROM sensorML";
  if ( isset( $filterstr ) && $filterstr != '' && isset( $filterfield ) && $filterfield != '' ) {
    $sql .= " where " . sqlstr( $filterfield ) . " like '" . $filterstr . "'";
  } elseif ( isset( $filterstr ) && $filterstr != '' ) {
    $sql .= " where (Organization like '" . $filterstr . "') or (Project like '" . $filterstr . "') or (URN like '" . $filterstr . "') or (Description like '" . $filterstr . "') or (sensorML like '" . $filterstr . "') or (Version like '" . $filterstr . "') or (Contact like '" . $filterstr . "') or (Contact_Email like '" . $filterstr . "')";
  }

  $db = $_SERVER[ 'DOCUMENT_ROOT' ] . $db";
  try {
    $dbh = new PDO( "sqlite:" . $db );
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  } catch ( PDOException $e ) {
    $dbh->rollBack();
    echo "Error!" . $e->getMessage() . "<br/>";
    die();
  }

  $res = $dbh->query( $sql );
  #$res = $conn->query($sql);
  $row = sqlite_fetch_array_ex( $res );
  reset( $row );
  $dbh->null;
  return current( $row );
}

function sqlite_fetch_array_ex( $res ) {
  if ( !( $tmprow = $res->fetch( PDO::FETCH_ASSOC ) ) )
    return false;
  $resrow = array();
  foreach ( $tmprow as $key => $value ) {
    $key = preg_replace( '/^"(.+)"$/', '\1', $key );
    $resrow[ $key ] = $value;
  }
  return $resrow;
}

function sqlstr( $val ) {
  return str_replace( "'", "''", $val );
}

# this the end of the php sets of codes
?>
<?php

function showpagenav( $page, $pagecount ) {
  ?>
<table class="bd" border="0" cellspacing="1" cellpadding="4" width="100%">
  <tr>
    <?php if ($page > 1) { ?>
    <td><a href="index.php?page=<?php echo $page - 1 ?>">&lt;&lt;&nbsp;Prev</a>&nbsp;</td>
    <?php } ?>
    <?php
    global $pagerange;
    if ( $pagecount > 1 ) {
      if ( $pagecount % $pagerange != 0 ) {
        $rangecount = intval( $pagecount / $pagerange ) + 1;
      } else {
        $rangecount = intval( $pagecount / $pagerange );
      }
      for ( $i = 1; $i < $rangecount + 1; $i++ ) {
        $startpage = ( ( $i - 1 ) * $pagerange ) + 1;
        $count = min( $i * $pagerange, $pagecount );
        if ( ( ( $page >= $startpage ) && ( $page <= ( $i * $pagerange ) ) ) ) {
          for ( $j = $startpage; $j < $count + 1; $j++ ) {
            if ( $j == $page ) {
              ?>
    <td><b><?php echo $j ?></b></td>
    <?php } else { ?>
    <td><a href="index.php?page=<?php echo $j ?>"><?php echo $j ?></a></td>
    <?php
    }
    }
    } else {
      ?>
    <td><a href="index.php?page=<?php echo $startpage ?>"><?php echo $startpage ."..." .$count ?></a></td>
    <?php
    }
    }
    }
    ?>
    <?php
    if ( $page < $pagecount ) {
      ?>
    <td>&nbsp;<a href="index.php?page=<?php echo $page + 1 ?>">Next&nbsp;&gt;&gt;</a>&nbsp;</td>
    <?php
    }
    ?>
  </tr>
</table>
<?php
}
?>
