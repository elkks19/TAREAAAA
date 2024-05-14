<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Calendar from 'primevue/calendar';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import Tag from 'primevue/tag';
import ProgressBar from 'primevue/progressbar';
import Slider from 'primevue/slider';
import Button from 'primevue/button';
import Toolbar from 'primevue/toolbar';
import Dialog from 'primevue/dialog';
import ConfirmDialog from 'primevue/confirmdialog';
import Toast from 'primevue/toast';
import ContextMenu from 'primevue/contextmenu';
import FloatLabel from 'primevue/floatlabel';
import Password from 'primevue/password';
</script>

<template>
    <AuthenticatedLayout>

        <Toolbar class="mb-4">
            <template #start>
                <Button label="Nuevo" icon="pi pi-plus" severity="success" class="mr-2" @click="create = true" />
                <Button label="Eliminar" icon="pi pi-trash" severity="danger" @click="confirmarEliminacion()" :disabled="!selectedData || !selectedData.length" />
            </template>
            <template #end>
                <Button label="Exportar" icon="pi pi-upload" severity="help" @click="exportCSV($event)"  />
            </template>
        </Toolbar>

        <ContextMenu ref="cm" :model="menuModel" @hide="selectedRow = null" />

        <DataTable :value="datos" tableStyle="min-width: 50rem" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort
                showGridlines ref="dt" v-model:selection="selectedData" @row-contextmenu="onRowContextMenu"
                v-model:contextMenuSelection="selectedRow" :contextMenuSelection="selectedRow" contextMenu>

            <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
            <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.header" sortable />

            <!-- <Column header="Tareas"> -->
            <!--     <template #body="slotProps"> -->
            <!--         <Button icon="pi pi-eye" @click="verTareas(slotProps.data.id)" /> -->
            <!--     </template> -->
            <!-- </Column> -->

        </DataTable>

    <!--DIALOGO PARA ELIMINAR-->
    <ConfirmDialog group="eliminar">
        <template #message="slotProps">
            <div class="flex flex-column align-items-center w-full gap-3 border-bottom-1 surface-border">
                <i :class="slotProps.message.icon" class="text-5xl text-primary-500"></i>
                <p>{{ slotProps.message.message }}</p>
            </div>
        </template>
    </ConfirmDialog>

    <!--DIALOGO PARA CREAR-->
    <Dialog v-model:visible="create" modal>
        <template #header>
            <span class="p-text-secondary block w-full">Crear nuevo usuario.</span>
        </template>

            <FloatLabel class="w-full mt-8">
                <InputText id="nameCreate" class="w-full" v-model="newTarea['name']" />
                <label for="nameCreate" class="font-semibold"> Nombre Usuario </label>
            </FloatLabel>

            <FloatLabel class="w-full mt-8">
                <InputText id="emailCreate" class="w-full" v-model="newTarea['email']" />
                <label for="emailCreate" class="font-semibold"> Email </label>
            </FloatLabel>

            <FloatLabel class="w-full mt-8">
                <Password id="passwordCreate" class="w-full" v-model="newTarea['password']" :feedback="false" toggleMask/>
                <label for="passwordCreate" class="font-semibold"> Contraseña </label>
            </FloatLabel>

        <template #footer>
            <Button label="Cancelar" text severity="secondary" @click="cancelar()" autofocus />
            <Button label="Guardar" outlined severity="secondary" @click="store()" autofocus />
        </template>
    </Dialog>

    <!--DIALOGO PARA EDITAR-->
    <Dialog v-model:visible="edit" modal>
        <template #header>
            <span class="p-text-secondary block w-full">Editar usuario.</span>
        </template>

            <FloatLabel class="mt-8" >
                <InputText id="nameEdit" v-model="editableData.nombre" class="w-full"/>
                <label for="nameEdit" class="font-semibold "> Nombre Usuario </label>
            </FloatLabel>

            <FloatLabel class="mt-8" >
                <InputText id="emailEdit" v-model="editableData.email" class="w-full"/>
                <label for="emailEdit" class="font-semibold "> email </label>
            </FloatLabel>

            <FloatLabel class="mt-8" >
                <Password id="passwordEdit" v-model="editableData.password" class="w-full" :feedback="false" toggleMask/>
                <label for="passwordEdit" class="font-semibold "> Contraseña </label>
            </FloatLabel>

        <template #footer>
            <Button label="Cancelar" text severity="secondary" @click="cancelar()" autofocus />
            <Button label="Guardar" outlined severity="secondary" @click="update()" autofocus />
        </template>
    </Dialog>


<!--TOAST-->
<Toast/>

</AuthenticatedLayout>

</template>


<script>

import { useToast } from 'primevue/usetoast';

export default {
    data() {
        return {
            tomorrow: new Date(),

            columns: [
                { field: 'id', header: 'ID', type: 'string' },
                { field: 'nombre', header: 'Nombre Usuario', type: 'string' },
                { field: 'email', header: 'Email', type: 'email' },
                { field: 'created_at', header: 'Creacion', type: 'date' },
                { field: 'updated_at', header: 'UltimaEdicion', type: 'date' },
            ],

            menuModel: [
                {label: 'Editar', icon: 'pi pi-fw pi-pen-to-square', command: () => this.editar(this.selectedRow) },
                {label: 'Eliminar', icon: 'pi pi-fw pi-times', command: () => this.confirmarEliminacion(this.selectedRow) }
            ],

            datos: [],
            tareas: [],
            editableTareas: [],

            selectedData: null,
            selectedRow: null,
            editableData: null,

            newTarea: {
                nombre: null,
                descripcion: null,
                fechaVencimiento: null,
                estado: null
            },

            create: false,
            edit: false,
            tasks: false,

            toast: null,
            customers: null,
            selectedCustomers: null,
        };
    },
    mounted() {
        this.actualizarDataTable();
        this.toast = useToast();
        this.tomorrow.setDate(this.tomorrow.getDate() + 1);
    },
    methods: {
        cancelar(){
            this.create = false;
            this.edit = false;
            this.newTarea = {
                nombre: null,
                descripcion: null,
                fechaVencimiento: null,
                estado: null
            };
        },
        confirmarEliminacion(row = null) {
            let task = row ? 'la tarea: ' + row.nombre : 'las ' + this.selectedData.length + ' tareas';

            this.$confirm.require({
                group: 'eliminar',
                header: 'Confirmar eliminación',
                message: '¿Estás seguro de que deseas eliminar ' + task + '?',
                icon: 'pi pi-exclamation-circle',
                acceptIcon: 'pi pi-check',
                rejectIcon: 'pi pi-times',
                rejectClass: 'p-button-outlined p-button-sm',
                acceptClass: 'p-button-sm',
                rejectLabel: 'Cancelar',
                acceptLabel: 'Eliminar',
                accept: () => {
                    if (row) {
                        this.remove(row);
                    } else{
                        this.selectedData.forEach(row => {
                            this.remove(row);
                        });
                    }

                    this.$toast.add({ severity: 'info', summary: 'Confirmado', detail: 'Haz eliminado el registro correctamente', life: 3000 });
                },
                reject: () => {
                    this.$toast.add({ severity: 'error', summary: 'Rejected', detail: 'Eliminación cancelada', life: 3000 });
                }
            });
        },

        actualizarDataTable() {
            window.axios({
                method: 'get',
                url: '/users',
            }).then(response => {
                console.log(response.data);
                this.datos = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        onRowContextMenu(event) {
            this.selectedRow = event.data;
            this.$refs.cm.show(event.originalEvent);
            event.originalEvent.preventDefault();
        },
        getSeverity(status) {
            switch (status) {
                case 'pendiente':
                    return 'warning';

                case 'en_proceso':
                    return 'info';

                case 'terminada':
                    return 'success';
            }
        },
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        remove(row) {
            window.axios({
                method: 'delete',
                url: '/users/' + row.id,
            }).then(response => {
                this.actualizarDataTable();
            }).catch(error => {
                console.log(error);
            });
        },
        editar(row) {
            console.log(row);
            this.edit = true;
            this.editableData = row;
        },
        update(){
            window.axios({
                method: 'put',
                url: '/users/' + this.editableData.id,
                data: this.editableData
            }).then(response => {
                this.actualizarDataTable();
                this.cancelar();
            }).catch(error => {
                console.log(error);
            });
        },
        store(){
            window.axios({
                method: 'post',
                url: '/users',
                data: this.newTarea
            }).then(response => {
                this.actualizarDataTable();
                this.cancelar();
            }).catch(error => {
                console.log(error);
            });
        },
    }
};

</script>
