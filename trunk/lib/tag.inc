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

/**
 * Add tags to DB or increase its count and returns comma-separated list of valid tags
 *
 * @param string $tags comma-separated tags list
 * @return string
 */
function tags_add_list($tags) {
    $list = array();
    foreach (tags_explode($tags) as $tag) {
        if (tags_add($tag)) $list[] = $tag;
    }
    return implode(', ', $list);
}

/**
 * Decrease tags count and returns comma-separated list of valid tags
 *
 * @param string $tags comma-separated tags list
 * @return string
 */
function tags_remove_list($tags) {
    $list = array();
    foreach (tags_explode($tags) as $tag) {
        if (tags_remove($tag)) $list[] = $tag;
    }
    return implode(', ', $list);
}

/**
 * Try to add new tag or decrease existing tag count
 *
 * @param string $tag single tag
 * @return bool
 */
function tags_add($tag) {
    if (!tags_is_valid($tag)) return false;
    $id = tags_get_id($tag);
    if ($id) {
        db_query('UPDATE tags SET num = num + 1 WHERE id = %d', $id);
    } else {
        db_query('INSERT INTO tags SET name = %s, num = 1', $tag);
    }
    return true;
}

/**
 * Decrease tag count
 *
 * @param string $tag single tag
 * @return bool
 */
function tags_remove($tag) {
    if (!tags_is_valid($tag)) return false;
    $id = tags_get_id($tag);
    if ($id) {
        db_query('UPDATE tags SET num = num - 1 WHERE id = %d', $id);
    }
    return true;
}

/**
 * Create array of tags from comma-separated list
 *
 * @param string $tags comma-separated tags list
 * @return array
 */
function tags_explode($tags) {
    $list = explode(',', $tags);
    trim_array($list);
    return $list;
}

/**
 * Check if the tag exists and get it ID
 *
 * @param string $tag single tag
 * @return int
 */
function tags_get_id($tag) {
    return db_result(db_query('SELECT id FROM tags WHERE LOWER(name) = LOWER(%s)', $tag));
}

/**
 * Check if the string is valid tag
 *
 * @param string $tag single tag
 * @return bool
 */
function tags_is_valid($tag) {
    $len = strlen($tag);
    return ($len > 2 && $len < 40 && strpos($tag, '>')===false && strpos($tag, '<')===false && strpos($tag, '/')===false && strpos($tag, '#')===false);
}
/**
 * Generate shuffled array of tags with size
 *
 * @param db_query result $result
 * @return array
 */
function generate_tag_array($result) {
    $font_size=32;
    $min_font=8;
    $num=db_num_rows($result);
    $count=($font_size-$min_font)/$num;
    $tags=null;
    while ($row=db_fetch_assoc($result)) {
        $tags[]=array('name'=>$row['name'],'size'=>$font_size);
        $font_size-=$count;
    }
    shuffle($tags);
    return($tags);
}
?>