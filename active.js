const all = ele => document.querySelectorAll(ele)
        const one = ele => document.querySelector(ele)
        const slide = _ => {
          const wrap = one('.slide') 
          const target = wrap.children[0] 
          const len = target.children.length 
        
          
          target.style.cssText = `width:calc(100% * ${len});display:flex;transition:1s`
        
          
          Array.from(target.children)
          .forEach(ele => ele.style.cssText = `width:calc(100% / ${len});`)
        
          
          let pos = 0
          setInterval(() => {
            pos = (pos + 1) % len 
            target.style.marginLeft = `${-pos * 100}%`
          }, 2000) 
        }
        window.onload = function () {
          slide()
        }