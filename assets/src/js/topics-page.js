const newTopicForm = jQuery("#new-topic-form");
const newTopicFormUrl = newTopicForm.attr("url");
const newTopicFormAction = newTopicForm.attr("action");

const newTopicNameInput = jQuery("#new-topic-name");
const newTopicSlugInput = jQuery("#new-topic-slug");
console.log(newTopicFormUrl);

newTopicForm.submit(event => {
    event.preventDefault();

    let name = newTopicNameInput.val();
    let slug = newTopicSlugInput.val();

    let nameLengthIsInvalid = name.length == 0;
    let slugLengthIsInvalid = slug.length == 0;

    // if (nameLengthIsInvalid || slugLengthIsInvalid) {
        

    //     return;
    // }

    const data = {
        'action': newTopicFormAction,
        'new-topic-name': name,
        'new-topic-slug': slug,
    };

    const onSuccess = data => {
        alert(data);
    };

    jQuery.post(newTopicFormUrl, data, onSuccess);
});


const deleteTopicButtons = jQuery("a.topic-delete-button");

for (let i = 0; i < deleteTopicButtons.length; i++) {
    const deleteTopicButton = jQuery(deleteTopicButtons[i]);

    const topicId = deleteTopicButton.attr("data-topic-id");
    const topicName = deleteTopicButton.attr("data-topic-name");
    const actionName = deleteTopicButton.attr("data-action-name");
    const url = deleteTopicButton.attr("data-url");

    deleteTopicButton.click(() => {
        const wasConfirmed = confirm(`Are you sure you want to delete "${topicName}"`);

        if (wasConfirmed == false)
            return;
        
        const data = {
            'action': actionName,
            'topic-id': topicId
        };

        const onSuccess = data => {
            window.location.reload();
        };

        jQuery.post(url, data, onSuccess);
    });
    
}