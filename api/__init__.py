
from flask import Flask
from .usuario.usuario import usuarios_bp
from .empleados.empleados import empleados_bp
from .transporte.transporte import transportes_bp
from .Metas_Pagos.mataspagos import metas_pagos_bp
from .Auditoria.auditoria import auditoria_bp
from .Documentacion.documentacion import constancia_bp
from .Vacaciones.vacaciones import vacaciones_bp
from .loggin.loggin import loggin

from flask_cors import CORS

# Registra el Blueprint
# Esto hará que las rutas definidas en products_bp sean accesibles a través de /products
def create_app():
    app = Flask(__name__)
    app.register_blueprint(usuarios_bp)
    app.register_blueprint(empleados_bp)
    app.register_blueprint(transportes_bp)
    app.register_blueprint(metas_pagos_bp)
    app.register_blueprint(auditoria_bp)
    app.register_blueprint(constancia_bp)
    app.register_blueprint(vacaciones_bp)
    app.register_blueprint(loggin)
    
    app.config['JSON_AS_ASCII'] = False  # Permite caracteres especiales en JSON
    app.config['JSON_SORT_KEYS'] = False  # No ordena las claves del JSON
    app.config['SECRET_KEY'] = 'nomina2020'
    CORS(app, origins=['*'])  # Habilita CORS para todas las rutas
    return app

