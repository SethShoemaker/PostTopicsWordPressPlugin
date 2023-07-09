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

    if (nameLengthIsInvalid || slugLengthIsInvalid) {
        

        return;
    }

    jQuery.post({
        url: newTopicFormUrl,
        data: {
            'action': newTopicFormAction,
            'new-topic-name': name,
            'new-topic-slug': slug,
        }
    });
});