import { useError } from "../context/ErrorContext";
import { useSignUp } from "../hooks/useSignUp";

export const SignUp = ({moveForm}) => {
  const {isLoading, signUpUser} = useSignUp();
  const { showError } = useError();

  const submitData = (e)=>{
    e.preventDefault();
    const formData = {
      name: e.target.name.value,
      email: e.target.email.value,
      password: e.target.password.value,
      password_confirmation: e.target.password.value,
      is_admin: false 
    };

    // Validación de la Contraseña
    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!passwordRegex.test(formData.password)) {
      showError("La contraseña debe tener: Al menos 8 caracteres. Solo letras o numeros. Incluir al menos una letra. Incluir al menos un numero", "Reglas", false);
      return;
    }
    
    signUpUser(formData);
  }

  return <div className='auth-content signup-form'>
    <h2 className='dash-title'>Registrarse</h2>
    <form className='dash-form' onSubmit={submitData}>
      <input type="text" name="name" placeholder="Nombre" required/>
      <input type="email" name="email" placeholder="Correo electrónico" required/>
      <input type="password" name="password" placeholder="Contraseña" required/>

      <div className="button-container">
        <button type="submit">
          {isLoading 
            ? <span className='loading'>...</span>
            : (<>Registrarse</>)
          }
        </button>
        <button type="button" onClick={()=> moveForm("left")}>Iniciar Sesión</button>
      </div>
    </form>
  </div>
}