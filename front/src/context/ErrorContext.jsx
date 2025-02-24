import React, { createContext, useState, useContext } from 'react';
import { Modal } from "../components/commons/Modal";

const ErrorContext = createContext();

export const ErrorProvider = ({ children }) => {
  const [error, setError] = useState(null);

  const showError = (message = "No se pudo conectar con el servidor. Inténtalo de nuevo más tarde.", status = 500, reload = true) => {
    setError({ message, status, reload });
  };

  const resetError = (reload) => {
    setError(null);
    if (reload) window.location.reload();
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