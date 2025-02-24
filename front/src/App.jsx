import React from 'react'
import { Grid } from './components/Grid';
import { Header } from './layouts/Header';
import { Footer } from './layouts/Footer';
import { AuthProvider } from './context/AuthContext';
import { NotifierProvider } from './context/NotifierContext';
import { ErrorProvider } from './context/ErrorContext';

export const App = () => {

  return (
    <AuthProvider>
      <NotifierProvider>
        <ErrorProvider>
          <Header />
          <Grid/>
          <Footer/>
        </ErrorProvider>
      </NotifierProvider>
    </AuthProvider>
  )
};