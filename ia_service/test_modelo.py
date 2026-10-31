import pickle
import sklearn

print("Scikit-learn:", sklearn.__version__)

try:
    with open('modelo_rf.pkl', 'rb') as archivo:
        modelo = pickle.load(archivo)

    print("Modelo cargado correctamente")
    print("Tipo:", type(modelo))

except Exception as e:
    print("Error al cargar el modelo:")
    print(repr(e))