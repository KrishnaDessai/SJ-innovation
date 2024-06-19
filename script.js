let UserSearchValue = document.getElementById('UserSearchValue');
let debounceTimeout;
let searchValue = "";
let form_submit = document.getElementById('form-submit');

window.onload = function() {
    let storedValue = localStorage.getItem('searchValue');
    if (storedValue) {
        UserSearchValue.value = storedValue;
    }
};

UserSearchValue.addEventListener("input", () => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        searchValue = UserSearchValue.value;
            localStorage.setItem('searchValue', searchValue);
            form_submit.submit();
    }, 600); // Adjust delay as needed
});



