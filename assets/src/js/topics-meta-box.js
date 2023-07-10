const appliedTopicsInput = document.querySelector("#sethshoemaker_post_topics_box input[name=sethshoemaker_post_topics_applied]");
const topicCheckboxes = document.querySelectorAll("#sethshoemaker_post_topics_box #post-topics-list .post-topic-list-item input[type=checkbox]");

setAppliedTopicsInput();

for (let i = 0; i < topicCheckboxes.length; i++) {
    const topicCheckbox = topicCheckboxes[i];

    topicCheckbox.addEventListener("click", setAppliedTopicsInput);
}

function setAppliedTopicsInput() {
    let newAppliedTopicsValue = [];

    for (let i = 0; i < topicCheckboxes.length; i++) {
        const topicCheckbox = topicCheckboxes[i];
        
        const topicShouldBeAddedToInput = topicCheckbox.checked;
        if (topicShouldBeAddedToInput) {
            const topicId = parseInt(topicCheckbox.getAttribute("data-topic-id"));

            newAppliedTopicsValue.push(topicId);
        }
    }

    appliedTopicsInput.value = JSON.stringify(newAppliedTopicsValue);
}