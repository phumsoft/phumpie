<?php

function trans_actions($module)
{
    $actions = [
        'created' => __('pattern.LABEL_hasBeenCreatedSuccessfully', ['LABEL' => __('common.' . $module)]),
        'updated' => __('pattern.LABEL_hasBeenUpdatedSuccessfully', ['LABEL' => __('common.' . $module)]),
        'removed' => __('pattern.LABEL_hasBeenRemovedSuccessfully', ['LABEL' => __('common.' . $module)]),
        'deleted' => __('pattern.LABEL_hasBeenDeletedSuccessfully', ['LABEL' => __('common.' . $module)]),
        'duplicated' => __('pattern.LABEL_hasBeenDuplicatedSuccessfully', ['LABEL' => __('common.' . $module)]),
        'uploaded' => __('pattern.LABEL_hasBeenUploadedSuccessfully', ['LABEL' => __('common.' . $module)]),
        'saved' => __('pattern.LABEL_hasBeenSavedSuccessfully', ['LABEL' => __('common.' . $module)]),
        'delete_related' => __('pattern.itemAreUsedItemsAndCannotBeDeleted'),
    ];

    return $actions;
}

function parse_trans($message, $prefix = 'app')
{
    $tagname = 'NT'; // NT = not translation
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";

    preg_match($pattern, $message, $matches);
    if (count($matches) > 0 && $matches[1]) {
        $first_msg = explode('<NT>', $message)[0];

        return __($prefix . '/' . $first_msg) . ' ' . $matches[1];
    } else {
        return __($prefix . '/' . $message);
    }
}
