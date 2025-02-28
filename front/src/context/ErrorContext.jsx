import React, { createContext, useState, useContext } from 'react';
import { Modal } from "../components/commons/Modal";
import { useNotifier } from './NotifierContext';

const ErrorContext = createContext();

export const ErrorProvider = ({ children }) => {
  const [error, setError] = useState(null);

  const { trigger } = useNotifier();

  const showError = (message = "No se pudo conectar con el servidor. Inténtalo de nuevo más tarde.", status = 500, reload = false) => {
    setError({ message, status, reload });
  };

  const resetError = (reload) => {
    if (error?.status === 401 || error?.status === 403 ){
      trigger('force-logout') // Cerrar sesión en caso de error 401 o 403
    }
    else
      trigger('error'); // Notificar error genérico

    setError(null);
    
    if (reload) window.location.reload(); // Recargar la página si es necesario
  };

  return (
    <ErrorContext.Provider value={{ error, showError }}>
      {children}
      {error 
      ? <Modal 
          onConfirm={() => resetError(error.reload)} 
          message={error.message} 
          title={error.status}
          buttonText={error.reload ? "Recargar Cuponly" : "Aceptar"}
        />
      : <></>
      }
    </ErrorContext.Provider>
  );
};

export const useError = () => {
  return useContext(ErrorContext);
};