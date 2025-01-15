const sideBar = document.querySelector('#side-menu');
const sideChoices = sideBar.querySelectorAll('button');
const contentSections = document.querySelectorAll('.content-section');


sideChoices.forEach(choice => {
    choice.addEventListener('click', () => {
        const sectionId = choice.dataset.section;
        contentSections.forEach(section => {
            section.classList.add('hidden');
        });
        const selectedSection = document.querySelector(`#${sectionId}`);
        selectedSection.classList.remove('hidden');

    });
});