
const toggleBtn = document.querySelector('.header__navbar--toggle-btn');
const toggleBtnIcon = document.querySelector('.header__navbar--toggle-btn i');
const dropDownMenu = document.querySelector('.header__navbar--dropdown-menu');

toggleBtn.onclick = function(){
    dropDownMenu.classList.toggle('open_menu')
    const isOpen = dropDownMenu.classList.contains('open_menu')

toggleBtnIcon.classList = isOpen
    ? 'bx bx-x'
    :'bx bx-menu'
}
