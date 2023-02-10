import './bootstrap';
import Search from './live-search'
import Chat from './chat'
import Profile from './profile'

//This mean if the header has a search button, you can do a search
if(document.querySelector(".header-search-icon")){
    new Search()
}

//This mean if the header has a chat button, you can do a search
if(document.querySelector(".header-chat-icon")){
    new Chat()
}

if(document.querySelector(".profile-nav")){
    new Profile()
}