const editTopicForm = jQuery("#edit-topic-form");
const editTopicFormUrl = editTopicForm.attr("url");
const editTopicFormAction = editTopicForm.attr("action");
const editTopicFormTopicId = editTopicForm.attr("topic-id")

const editTopicNameInput = jQuery("#edit-topic-name");
const editTopicSlugInput = jQuery("#edit-topic-slug");

editTopicForm.submit(event => {
    event.preventDefault();

    let name = editTopicNameInput.val();
    let slug = editTopicSlugInput.val();

    let nameLengthIsInvalid = name.length == 0;
    let slugLengthIsInvalid = slug.length == 0;

    // if (nameLengthIsInvalid || slugLengthIsInvalid) {
        

    //     return;
    // }

    const data = {
        'action': editTopicFormAction,
        'edit-topic-id': editTopicFormTopicId,
        'edit-topic-name': name,
        'edit-topic-slug': slug,
    };

    const onSuccess = data => {
        alert(data);
    };

    jQuery.post(editTopicFormUrl, data, onSuccess);
});