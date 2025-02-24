
import { useState } from 'react';
import { LogIn } from "./LogIn"
import { SignUp } from "./SignUp"

export const Auth = () => {
  const [formSide, setFormSide] = useState("left");

  return <div className="auth-wrapper">
      <div className={`inner-container ${formSide}`}>
        <LogIn moveForm={setFormSide}/>
        <SignUp moveForm={setFormSide}/>
      </div>
    </div>
}