# wp-table-class

To use this class you have to require the class first.<br />
require_once("wp-table-class.php");<br />
<br />
load the class inside your page:<br />
$WPTable = new wp_table_class;<br />
<br />
Now the class is loaded you can use it like this:<br />
$WPTable->set_columns(array(<br />
&emsp;&emsp;&emsp;&emsp;&emsp;'ID' => 'ID',<br />
&emsp;&emsp;&emsp;&emsp;&emsp;'user_login'    => 'Username',<br />
&emsp;&emsp;&emsp;&emsp;&emsp;'user_nicename' => 'Name',<br />
&emsp;&emsp;&emsp;&emsp;&emsp;'user_email'    => 'Email',<br />
&emsp;&emsp;&emsp;&emsp;&emsp;'user_url'    	=> 'Url'<br />
        ));<br />
<br />
$WPTable->set_sortable_columns(array('ID' => array('ID', false)));<br />
$WPTable->prepare_items("SELECT * FROM wp_users");<br />
<br />
To display the table you have to set the display, the display can be set inside divs.<br />
$WPTable->display();<br />
<br />
This is all you have to know to create a wordpress table<br />
