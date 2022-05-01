import { Link } from "react-router-dom";
import "./topbar.css"

export default function TopBar() {
  const user = false;
  return (
    <div className="top">
        <div className="topLeft">
            <Link className="link" to="/" >MNIST by humans</Link>
            <i className="topIconLeft fa-solid fa-globe"></i>
        </div>
        <div className="topCenter"></div>
        <div className="topRight">
            <ul className="topList">
              {user ? (
                <>
                <li className="topListItem"><i className="topIcon fa-solid fa-gears"></i></li>
                <li className="topListItem">MNIST</li></>
              ): (
                <>
                <li className="topListItem"><i className="topIcon fa-solid fa-user"></i></li>
                <li className="topListItem"><Link className="link" to="/login" >Bejelentkezés</Link></li>
                <li className="topListItem"><i className="topIcon fa-solid fa-user-plus"></i></li>
                <li className="topListItem"><Link className="link" to="/register" >Regisztráció</Link></li>
                <li className="topListItem"><i className="topIcon fa-solid fa-gears"></i></li>
                <li className="topListItem">MNIST</li></>
              )}
                
            </ul>
        </div>
    </div>
  )
}
