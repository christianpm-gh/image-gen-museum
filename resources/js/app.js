import Alpine from 'alpinejs';

window.museumSelection = {
    single({ initialValue = '' } = {}) {
        return {
            selectedValue: initialValue ? String(initialValue) : '',
            isSelected(value) {
                return this.selectedValue === String(value);
            },
            select(value) {
                this.selectedValue = String(value);
            },
        };
    },

    multiLimit({ requiredCount = 1, initialSelected = [] } = {}) {
        return {
            requiredCount: Number(requiredCount),
            selectedIds: initialSelected.map((value) => String(value)),
            isSelected(value) {
                return this.selectedIds.includes(String(value));
            },
            isDisabled(value) {
                return !this.isSelected(value) && this.selectedIds.length >= this.requiredCount;
            },
            remaining() {
                return Math.max(this.requiredCount - this.selectedIds.length, 0);
            },
            helperText() {
                if (this.selectedIds.length === this.requiredCount) {
                    return 'Limite alcanzado. Puedes deseleccionar una imagen para cambiar tu combinacion.';
                }

                if (this.selectedIds.length === 0) {
                    return `Debes seleccionar ${this.requiredCount} ${this.requiredCount === 1 ? 'imagen' : 'imagenes'} antes de enviar.`;
                }

                return `Te falta ${this.remaining()} ${this.remaining() === 1 ? 'imagen' : 'imagenes'} para completar tu ticket.`;
            },
            canSubmit() {
                return this.selectedIds.length === this.requiredCount;
            },
        };
    },
};

window.Alpine = Alpine;

Alpine.start();
