import "./home.css"
import Header from "../../header/Header";

export default function Home() {
  return (
    <div className="home">
        <Header/>
        <div class="guestmessage">
                <p className="guestMessage">Maga nincs bejelentkezve!</p>
                <p>Továbbra is használhatja az oldalt, de korábbi próbálkozásait nem tudja visszanézni, illetve felhasználónevét nem tudja megváltoztatni!</p>
                </div>
        <p></p>
        <h1><u>Rangsor:</u></h1>
        {/* todo: táblázat*/}
    </div>
  )
}

