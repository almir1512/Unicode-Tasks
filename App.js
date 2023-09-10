import React from "react"
import Timer from "./Die"
import Settings from "./Settings"
import {nanoid} from "nanoid"
import Confetti from "react-confetti" 
import {useState} from "react"
// import reactSlider from "react-slider"
export default function App() {

    const [showSettings, setShowSettings] = useState(false);
    return (
        <main>
        {showSettings ? <Settings /> : <Timer />}
        
        </main>
    )
}
