from flask import Flask, request, jsonify
import pickle
import pandas as pd

app = Flask(__name__)

# 1. Cargar el modelo entrenado
modelo = pickle.load(open('modelo_rf.pkl', 'rb')) 

@app.route('/predecir', methods=['POST'])
def predecir():
    try:
        # Recibir los datos de Laravel
        datos = request.json
        
        # Convertir los datos a una tabla que el modelo entienda (DataFrame)
        # Las llaves deben ser idénticas a las columnas con las que entrenaste en Colab
        df = pd.DataFrame([{
            'inflacion_ipc': float(datos['inflacion']),
            'trm_promedio': float(datos['tasa_cambio']),
            'capex_millones': float(datos['capex']),
            'opex_proyectado': float(datos['opex']),
            'plazo_meses': int(datos['plazo_meses']),
            'tasa_interes': 0.15, # Tasa simulada (15%)
            'vpn_proyectado': float(datos['vpn']),
            'rcsd': float(datos['rcsd'])
        }])

        # 2. Hacer la predicción (predict_proba devuelve % de fracaso y % de éxito)
        probabilidad = modelo.predict_proba(df)[0][1] # Tomamos la probabilidad de éxito (1)
        porcentaje_exito = round(probabilidad * 100, 2)
        
        # Generar recomendación (Explicabilidad)
        recomendacion = "Viable." if porcentaje_exito >= 70 else "Riesgoso. Revisar Ratio de Deuda."

        return jsonify({
            'exito': True,
            'probabilidad': porcentaje_exito,
            'recomendacion': recomendacion
        })

    except Exception as e:
        return jsonify({'exito': False, 'error': str(e)})

if __name__ == '__main__':
    # El servidor Python correrá en el puerto 5000
    app.run(port=5000, debug=True)