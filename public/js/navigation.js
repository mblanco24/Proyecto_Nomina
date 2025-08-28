
    document.addEventListener('DOMContentLoaded', function () {
        const cambiarPassBtn = document.getElementById('change-password');

        if (cambiarPassBtn) {
            cambiarPassBtn.addEventListener('click', async () => {
                const { value: formValues } = await Swal.fire({
                    title: 'Cambiar Contraseña',
                    html:
                        `<input type="password" id="swal-new-password" class="swal2-input" placeholder="Nueva contraseña">` +
                        `<input type="password" id="swal-confirm-password" class="swal2-input" placeholder="Confirmar nueva contraseña">`,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    preConfirm: () => {
                        const newPass = document.getElementById('swal-new-password').value;
                        const confirmPass = document.getElementById('swal-confirm-password').value;

                        if (!newPass || !confirmPass) {
                            Swal.showValidationMessage('Todos los campos son obligatorios');
                            return;
                        }

                        if (newPass !== confirmPass) {
                            Swal.showValidationMessage('Las nuevas contraseñas no coinciden');
                            return;
                        }

                        return {
                            nueva_contraseña: newPass
                        };
                    }
                });

                if (formValues) {
                    // Aquí puedes hacer una petición fetch para cambiar la contraseña
                    console.log(formValues); // { old_password: '...', new_password: '...' }

                    try {
                        // Reemplaza con el ID real del usuario
                        const id_usuario = localStorage.getItem('id_usuario'); // Debes implementar esta función o variable

                        const response = await fetch(`${API_BASE_URL}/usuarios/cambiarcontraseña/${id_usuario}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(formValues)
                        });

                        const result = await response.json();

                        if (!response.ok) {
                            throw new Error(result.error || 'Error al cambiar la contraseña');
                        }

                        Swal.fire('Éxito', result.message, 'success');
                    } catch (error) {
                        Swal.fire('Error', error.message, 'error');
                    }
                }
            });
        }
    });