// Setup an event listener to make an API call once auth is complete
function onLinkedInLoad() {
    IN.Event.on(IN, "auth", getProfileData);
}

// Use the API call wrapper to request the member's basic profile data
function getProfileData() {
    IN.API.Profile("me").fields("first-name", "last-name", "email-address", "summary", "public-profile-url")
        .result(onSuccess)
        .error(onError);
}

// Handle the successful return from the API call
function onSuccess(data) {
    fillFormWithData(data.values[0]);
}

// Handle an error response from the API call
function onError(error) {
    console.log(error);
}

function fillFormWithData(data) {

    document.getElementById('firstname').value = (data.firstName !== undefined) ? data.firstName: '';
    document.getElementById('lastname').value = (data.lastName !== undefined) ? data.lastName: '';
    document.getElementById('applicant-email').value = (data.emailAddress !== undefined) ? data.emailAddress: '';
    document.getElementById('confirm-email').value = (data.emailAddress !== undefined) ? data.emailAddress: '';

}
