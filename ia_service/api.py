
from flask import Flask, request, jsonify
import joblib
import pandas as pd

app = Flask(__name__)

# 1. Cargar el modelo entrenado con Joblib
modelo = joblib.load('modelo_rf.pkl')


@app.route('/predecir', methods=['POST'])
def predecir():
    try:
        # Recibir los datos enviados desde Laravel
        datos = request.json
        print("Datos recibidos de Laravel:", datos)

        # Convertir los datos a un DataFrame
        datos_para_ia = [[
            float(datos['vpn']) / 1000000,  # 1. vpn_proyectado (en millones)
            float(datos['rcsd'])            # 2. rcsd (ratio puro)
        ]]
        # Realizar predicción
        probabilidad = modelo.predict_proba(datos_para_ia)[0][1] 
        porcentaje_exito = round(probabilidad * 100, 2)

        # Generar recomendación
        if porcentaje_exito >= 70:
            recomendacion = "PROYECTO VIABLE: El flujo de caja cubre la deuda holgadamente y genera valor (VPN positivo)."
        elif porcentaje_exito >= 40:
            recomendacion = "RIESGO MODERADO: El proyecto sobrevive, pero el margen ante imprevistos es estrecho."
        else:
            recomendacion = "ALTO RIESGO: El Ratio de Deuda es peligroso o el proyecto destruye valor. No se recomienda invertir."

        return jsonify({
            'exito': True,
            'probabilidad': porcentaje_exito,
            'recomendacion': recomendacion
        })

    except Exception as e:
        print("ERROR EN PYTHON:", str(e)) # Muestra el error real en la terminal
        return jsonify({'exito': False, 'error': str(e)})


if __name__ == '__main__':
    app.run(port=5000, debug=True)
