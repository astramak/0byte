<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License.
 *
 *  0byte is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  See <http://www.gnu.org/licenses/>.
 *
 */
include("cfg.php");
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
  <OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
   <ShortName><?php echo $sl_name;?></ShortName>
   <Description><?php echo $s_name;?></Description>
   <Url type="text/html" template="<?php echo $site; ?>?fnd={searchTerms}"/>
 </OpenSearchDescription>
