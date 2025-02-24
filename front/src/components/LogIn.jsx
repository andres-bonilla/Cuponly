import { useError } from "../context/ErrorContext";
import { useLogIn } from "../hooks/useLogIn";
export const LogIn = ({moveForm}) => {
  const {isLoading, logInUser} = useLogIn();
  const { showError } = useError();
  
  const submitData = (e)=>{
    e.preventDefault();
    const formData = {
      email: e.target.email.value,
      password: e.target.password.value,
    };

    // Validación de la Contraseña
    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!passwordRegex.test(formData.password)) {
      showError("La contraseña debe tener: Al menos 8 caracteres. Solo letras o numeros. Incluir al menos una letra. Incluir al menos un numero", "Reglas", false);
      return;
    }

    logInUser(formData);
  }

  return <div className='auth-content'>
    <h2 className='dash-title'>Iniciar Sesión</h2>
    <form className='dash-form' onSubmit={submitData}>
      <input type="email" name="email" placeholder="Correo electrónico" required/>
      <input type="password" name="password" placeholder="Contraseña" required/>

      <div className="button-container">
        <button type="submit">
          {isLoading 
            ? <span className='loading'>...</span>
            : (<>Iniciar Sesión</>)
          }
        </button>
        <button type="button" onClick={()=> moveForm("right")}>Registrarse</button>
      </div>
    </form>
  </div>
}