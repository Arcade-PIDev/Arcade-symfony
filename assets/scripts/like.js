export default class Like{
    constructor(LikeElements)
    {
        this.LikeElements = LikeElements;
        if (this.LikeElements){
            this.init();

        }

    }
    init(){
        this.LikeElements.map(element =>{
            element.addEventListener('click', this.onClick)
        })
    }

    onClick(event){
        event.preventDefault();
        const url = this.href;
    }
}