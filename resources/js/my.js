const sortForm = document.getElementById("sorting_select");
const sortSelect = document.getElementById("sorts");
sortSelect.addEventListener("change", function() {
    sortForm.submit();
});

const filterForm = document.getElementById("filtering_select");
const filterSelect = document.getElementById("filters");
filterSelect.addEventListener("change", function() {
    filterForm.submit();
});

const msgbtn = document.getElementById("check");
const msgcont = document.getElementById("msg_cont");
if (msgbtn) {
    msgbtn.addEventListener("click", function() {
        msgcont.classList.add('gone');
    });
}