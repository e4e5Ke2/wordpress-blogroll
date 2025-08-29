<?php

use My\Module\Blogroll\Site\Helper\RssFilter;

function presentForm($widget, $instance, $translations)
{
    $getValues = fn($id, $transId) => [
        'value' => array_key_exists($id, $instance) ? $instance[$id] : '',
        'field_name' => $widget->get_field_name($id),
        'field_id' => $widget->get_field_id($id),
        'label' => $translations->get($transId)
    ];

    $title = $getValues('title', 'MOD_BLOGROLL_FIELD_TITLE_LABEL');
    $rssUrls = $getValues('rssurl_list', 'MOD_BLOGROLL_FIELD_RSSURL_LABEL');
    $rssSorting = $getValues('rsssorting', 'MOD_BLOGROLL_FIELD_SORTING_LABEL');
    $rssImage = $getValues('rssimage', 'MOD_BLOGROLL_FIELD_IMAGE_LABEL');
    $rssAuthor = $getValues('rssauthor', 'MOD_BLOGROLL_FIELD_AUTHOR_LABEL');
    $rssDate = $getValues('rssitemdate', 'MOD_BLOGROLL_FIELD_DATE_LABEL');
    $rssDateFormat = $getValues('rssitemdate_format', 'MOD_BLOGROLL_FIELD_DATE_FORMAT_LABEL');
    $rssItemLimit = $getValues('rssitems_limit', 'MOD_BLOGROLL_FIELD_ITEMS_LIMIT_LABEL');
    $rssItemLimitCount = $getValues('rssitems_limit_count', 'MOD_BLOGROLL_FIELD_ITEMS_LIMIT_COUNT_LABEL');

    echo '<p>';

    label($title);
    textInput($title);

    label($rssUrls);
    textarea($rssUrls, $translations->get('MOD_BLOGROLL_FIELD_RSSURL_HINT'));

    echo '<p>';

    checkboxInput($rssSorting);
    label($rssSorting);

    echo '<p>';

    checkboxInput($rssImage);
    label($rssImage);

    echo '<p>';

    checkboxInput($rssAuthor);
    label($rssAuthor);

    echo '<p>';

    checkboxInput($rssDate);
    label($rssDate);

    echo '<p>';
    ?>

    <label for=<?= $rssDateFormat['field_name']; ?>><?= $rssDateFormat['label']; ?></label>

    <select name=<?= $rssDateFormat['field_name']; ?> id=<?= $rssDateFormat['field_id']; ?>>
        <option value="0" <?= $rssDateFormat['value'] == '0' ? 'selected' : ''; ?>>
            <?= $translations->get('MOD_BLOGROLL_FIELD_DATE_FORMAT_OPTION_0'); ?>
        </option>
        <option value="1" <?= $rssDateFormat['value'] == '1' ? 'selected' : ''; ?>>
            <?= $translations->get('MOD_BLOGROLL_FIELD_DATE_FORMAT_OPTION_1'); ?>
        </option>
        <option value="2" <?= $rssDateFormat['value'] == '2' ? 'selected' : ''; ?>>
            <?= $translations->get('MOD_BLOGROLL_FIELD_DATE_FORMAT_OPTION_2'); ?>
        </option>
    </select>

    <?php
    echo '</p>';

}

function label($values)
{
    echo '<label for="' . $values['field_name'] . '">' . $values['label'] . '</label>';
}

function textInput($values)
{
    echo '<input class="widefat" required id="' . $values['field_id'] . '" name="' . $values['field_name'] . '" type="text"
            value="' . esc_attr($values['value']) . '" />';
}

function checkboxInput($values)
{
    echo '<input class="widefat" id="' . $values['field_id'] . '" name="' . $values['field_name'] . '" type="checkbox"
            value="1" ' . ($values['value'] == "1" ? 'checked' : '') . ' />';
}

function textarea($values, $hint)
{
    echo '<textarea class="widefat" id="' . $values['field_id'] . '" cols="40" rows="10" name="' . $values['field_name'] . '" 
            placeholder="' . $hint . '" required>' . esc_attr($values['value']) . '</textarea>';
}

function updateForm($new_instance, $old_instance)
{
    $values = ['title', 'rsssorting', 'rssimage', 'rssauthor', 'rssitemdate', 'rssitemdate_format', 'rssitems_limit', 'rssitems_limit_count'];
    $instance = [];
    foreach ($values as $value) {
        $instance[$value] = (!empty($new_instance[$value])) ? strip_tags($new_instance[$value]) : '';
    }

    if ($new_instance['rssurl_list'] !== $old_instance['rssurl_list']) {
        $filter = new RssFilter();
        $instance['rssurl_list'] = $filter->filter($new_instance['rssurl_list']);
    }
    return $instance;
}