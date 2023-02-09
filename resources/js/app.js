import './bootstrap';
import Search from './live-search'
import Chat from './chat'


//This mean if the header has a search button, you can do a search
if(document.querySelector(".header-search-icon")){
    new Search
}

//This mean if the header has a chat button, you can do a search
if(document.querySelector(".header-chat-icon")){
    new Chat
}