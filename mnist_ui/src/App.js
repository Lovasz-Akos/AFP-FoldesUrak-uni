import Home from "./pages/home/Home";
import Login from "./pages/login/Login";
import Register from "./pages/register/Register";
import TopBar from "./topbar/TopBar";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";


function App() {
  const currentUser = false;
  return (
    <Router>
      <TopBar />
      <Routes>
        <Route path="/" element={<Home/>} />
        <Route path="/register" element={currentUser ? <Home/> : <Register/>} />
        <Route path="/login" element={currentUser ? <Home/> : <Login/>} />
      </Routes>
    </Router>
  );
}

export default App;
