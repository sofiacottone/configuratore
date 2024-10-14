# Pannello di Configurazione

Pannello di Configurazione sviluppato in PHP. Consente agli utenti di personalizzare un prodotto attraverso una serie di opzioni e configurazioni. Il sistema calcola il prezzo finale in base alle scelte effettuate dall'utente e offre un'interfaccia intuitiva.

## Funzionalità

- **Configurazione del Prodotto**: è possibile scegliere tra diverse opzioni e il tipo di abbonamento (mensile o annuale).
- **Calcolo Prezzo Dinamico**.
- **Design Responsive**.
- **Persistenza dei Dati**.

## Tecnologie Utilizzate

- **PHP**: Logica backend.
- **JavaScript**: Aggiornamenti dinamici dell'interfaccia utente e gestione dei moduli.
- **MySQL**: Database per la memorizzazione di fatture e dati dei clienti
- **LocalStorage**: Per mantenere i dati del carrello tra le sessioni.

## Installazione

Per ottenere una copia locale e farla funzionare, seguire questi passaggi:

1. **Clonare il repository**:
   ```bash
   git clone https://github.com/sofiacottone/configuratore
   ```
2. **Configurare il database**:

    Creare un nuovo database MySQL.

    Eseguire il file `schema.sql` fornito nel repository per creare le tabelle necessarie.

3. **Configurare la connessione al database**:

    Aprire il file `config.php` e aggiornare le credenziali del database.

4. **Eseguire l'applicazione**:
   ```bash
   php -S localhost:8888 -t public
   ```
5. **Accedere all'applicazione**:

    Aprire il browser e navigare su http://localhost:8000 per iniziare a configurare un prodotto.