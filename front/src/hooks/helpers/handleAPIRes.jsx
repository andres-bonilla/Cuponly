export const handleAPIRes = (res) => {
  if (res.ok) 
    return res.json().then((jsonRes)=> ({ result: jsonRes.data, status: res.status }))

  return res.json()
  .then((errorRes) => {
    // Si la API envió un error controlado en JSON, lo lanzamos
    const message = errorRes?.error === true ? errorRes.data : errorRes.message;
    throw { error: true, data: message, status: res.status || 500 };
  })
  .catch((error) => {
    // Si el error viene del then anterior lanzamos error
    if (error?.error)
      throw error;

    // Si `res.json()` falla (respuesta no es JSON válido), lanzamos error genérico
    throw { error: true, data: "Error desconocido. No se pudo procesar la respuesta.", status: res.status || 500 } 
  })
}