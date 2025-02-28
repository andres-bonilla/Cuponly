export const createErrorHandler = (showError, message) => {
  return (error) => {
    console.error(message, error);
  
    if (error?.error) // Si el error fue controlado
      showError(error.data, error.status);
    else // Error de red o algo inesperado
      showError("Error inesperado. Intenta de nuevo.");
  }
}