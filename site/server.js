import express from 'express';
import fetch from 'node-fetch';
import path from 'path';

const app = express();
const PORT = 8888;

// Configuración de credenciales de PayPal (NO recomendado para producción)
const PAYPAL_CLIENT_ID = 'ATP-_1Nv8pAQa_ZYMCONSMtC-LO3JPE44G892NeG5Uak9i8nXrEWjBt5ZHkAoo1Pqc3tb1R_y4UMEuzF';
const PAYPAL_CLIENT_SECRET = 'EBVuEyRIGkc7I-YuMZhrHq3wn9kyRvYPDIQ2G4KBDgI6VQqJFmkF3dCVd_mYMCKDCqwWkNNLazGHh5D2';
const base = 'https://api-m.sandbox.paypal.com'; // Sandbox URL para pruebas

app.use(express.static('client'));
app.use(express.json());

async function generateAccessToken() {
  const response = await fetch(`${base}/v1/oauth2/token`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'Authorization': `Basic ${Buffer.from(`${PAYPAL_CLIENT_ID}:${PAYPAL_CLIENT_SECRET}`).toString('base64')}`,
    },
    body: 'grant_type=client_credentials',
  });
  const data = await response.json();
  return data.access_token;
}

async function createOrder(cart) {
  const accessToken = await generateAccessToken();
  const url = `${base}/v2/checkout/orders`;
  const payload = {
    intent: 'CAPTURE',
    purchase_units: [
      {
        amount: {
          currency_code: 'USD',
          value: '100', // Ajusta esto según el total del carrito
        },
      },
    ],
  };

  const response = await fetch(url, {
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${accessToken}`,
    },
    method: 'POST',
    body: JSON.stringify(payload),
  });

  return response.json();
}

async function captureOrder(orderID) {
  const accessToken = await generateAccessToken();
  const url = `${base}/v2/checkout/orders/${orderID}/capture`;

  const response = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${accessToken}`,
    },
  });

  return response.json();
}

app.post('/api/orders', async (req, res) => {
  try {
    const { cart } = req.body;
    const orderData = await createOrder(cart);
    res.json(orderData);
  } catch (error) {
    res.status(500).json({ error: 'Failed to create order.' });
  }
});

app.post('/api/orders/:orderID/capture', async (req, res) => {
  try {
    const { orderID } = req.params;
    const captureData = await captureOrder(orderID);
    res.json(captureData);
  } catch (error) {
    res.status(500).json({ error: 'Failed to capture order.' });
  }
});

app.get('/', (req, res) => {
  res.sendFile(path.resolve('./checkout.html'));
});

app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
