import { createContext, useContext, useState, useEffect } from 'react';

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [session, setSession] = useState(
    JSON.parse(sessionStorage.getItem('session')) || null);

  useEffect(() => {
    if (session) {
      sessionStorage.setItem('session', JSON.stringify(session));
    } else {
      sessionStorage.removeItem('session');
      localStorage.removeItem('user-coupons');
    }
  }, [session]);

  const logIn = (newSession) => {
    setSession(newSession);
  };

  const logOut = () => {
    localStorage.removeItem('user-coupons');
    setSession(null);
  };

  return (
    <AuthContext.Provider value={{ session, logIn, logOut }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => {
  return useContext(AuthContext);
};