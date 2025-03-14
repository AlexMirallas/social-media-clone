document.getElementById('reply-textarea').addEventListener('focus', ()=> {
    this.rows = 3;
    this.classList.add('outline-none');
    document.getElementById('reply-buttons').classList.remove('hidden');
    document.getElementById('reply-container').classList.add('border', 'border-gray-300', 'p-4', 'rounded-2xl');
});

document.getElementById('cancel-button').addEventListener('click', ()=> {
    const textarea = document.getElementById('reply-textarea');
    textarea.value = '';
    textarea.rows = 1;
    document.getElementById('reply-buttons').classList.add('hidden');
    document.getElementById('reply-container').classList.remove('border', 'border-gray-300', 'p-4');
});

document.getElementById('submit-button').addEventListener('click', ()=> {
    // Add your submit logic here
    alert('Comment submitted!');
});

document.getElementById('sort-button').addEventListener('click', ()=> {
    document.getElementById('sort-menu').classList.toggle('hidden');
});

document.querySelectorAll('#sort-menu a').forEach((item)=> {
    item.addEventListener('click', function(event) {
        event.preventDefault();
        const sortOption = this.textContent;
        document.getElementById('sort-button').textContent = sortOption;
        document.getElementById('sort-menu').classList.add('hidden');
        // Add logic to fetch and render comments based on the selected sort option
        alert('Sorting by: ' + sortOption);
    });
});

document.getElementById('comment-reply').addEventListener('click', () => {
    document.getElementById('comment-reply-buttons').classList.toggle('hidden');
    document.getElementById('comment-reply-container').classList.toggle('hidden');
});